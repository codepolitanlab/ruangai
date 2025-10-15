<?php

namespace Logviewer\Controllers;

use Heroicadmin\Controllers\AdminController;
use Logviewer\Config\Logviewer as LogviewerConfig;

class Logviewer extends AdminController
{
    protected LogviewerConfig $config;

    public $data = [
        'page_title' => 'Log Viewer',
        'module'     => 'logviewer',
        'submodule'  => 'logviewer',
    ];
    
    public function __construct()
    {
        $this->config = new LogviewerConfig();
        helper('heroicsetting');
    }
    
    /**
     * Main log viewer page - list all log files
     */
    public function index()
    {
        $this->data['logFiles'] = $this->getLogFiles();

        return view('Logviewer\Views\index', $this->data);
    }
    
    /**
     * View specific log file content
     */
    public function view($filename)
    {
        if (!$this->isValidLogFile($filename)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Log file not found');
        }
        
        $filepath = $this->config->logPath . $filename;
        $page = (int) ($this->request->getGet('page') ?? 1);
        $search = $this->request->getGet('search') ?? '';
        
        $content = $this->getLogContent($filepath, $page, $search);
        
        $data = [
            'title' => 'Log Viewer - ' . $filename,
            'filename' => $filename,
            'content' => $content,
            'currentPage' => $page,
            'search' => $search,
            'totalLines' => $this->countLogLines($filepath),
        ];
        
        $this->data = array_merge($this->data, $data);
        return view('Logviewer\Views\view', $this->data);
    }
    
    /**
     * Download log file
     */
    public function download($filename)
    {
        if (!$this->isValidLogFile($filename)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Log file not found');
        }
        
        $filepath = $this->config->logPath . $filename;
        
        return $this->response->download($filepath, null);
    }
    
    /**
     * Delete specific log file
     */
    public function delete($filename)
    {
        if (!$this->isValidLogFile($filename)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Log file not found']);
        }
        
        $filepath = $this->config->logPath . $filename;
        
        if (unlink($filepath)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Log file deleted successfully']);
        }
        
        return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete log file']);
    }
    
    /**
     * Clear all log files
     */
    public function clearAll()
    {
        $files = $this->getLogFiles();
        $deleted = 0;
        
        foreach ($files as $file) {
            if ($file['name'] !== 'index.html') {
                $filepath = $this->config->logPath . $file['name'];
                if (unlink($filepath)) {
                    $deleted++;
                }
            }
        }
        
        return $this->response->setJSON([
            'success' => true, 
            'message' => "Successfully deleted {$deleted} log files"
        ]);
    }
    
    /**
     * API: Get list of log files
     */
    public function getFiles()
    {
        return $this->response->setJSON(['files' => $this->getLogFiles()]);
    }
    
    /**
     * API: Get log content with pagination
     */
    public function getContent($filename)
    {
        if (!$this->isValidLogFile($filename)) {
            return $this->response->setJSON(['error' => 'Log file not found']);
        }
        
        $filepath = $this->config->logPath . $filename;
        $page = (int) ($this->request->getGet('page') ?? 1);
        $search = $this->request->getGet('search') ?? '';
        
        $content = $this->getLogContent($filepath, $page, $search);
        
        return $this->response->setJSON([
            'content' => $content,
            'totalLines' => $this->countLogLines($filepath),
            'currentPage' => $page,
        ]);
    }
    
    /**
     * API: Search in log file
     */
    public function search($filename)
    {
        if (!$this->isValidLogFile($filename)) {
            return $this->response->setJSON(['error' => 'Log file not found']);
        }
        
        $query = $this->request->getGet('q') ?? '';
        if (empty($query)) {
            return $this->response->setJSON(['results' => []]);
        }
        
        $filepath = $this->config->logPath . $filename;
        $results = $this->searchInLog($filepath, $query);
        
        return $this->response->setJSON(['results' => $results]);
    }
    
    /**
     * Get list of log files with metadata
     */
    private function getLogFiles(): array
    {
        $files = [];
        $logPath = $this->config->logPath;
        
        if (!is_dir($logPath)) {
            return $files;
        }
        
        $iterator = new \DirectoryIterator($logPath);
        
        foreach ($iterator as $file) {
            if ($file->isFile() && in_array($file->getExtension(), $this->config->allowedExtensions)) {
                $files[] = [
                    'name' => $file->getFilename(),
                    'size' => $this->formatBytes($file->getSize()),
                    'modified' => date('Y-m-d H:i:s', $file->getMTime()),
                    'lines' => $this->countLogLines($file->getPathname()),
                ];
            }
        }
        
        // Sort by modification time (newest first)
        usort($files, function($a, $b) {
            return strtotime($b['modified']) - strtotime($a['modified']);
        });
        
        return $files;
    }
    
    /**
     * Check if filename is a valid log file
     */
    private function isValidLogFile(string $filename): bool
    {
        $filepath = $this->config->logPath . $filename;
        
        if (!file_exists($filepath) || !is_file($filepath)) {
            return false;
        }
        
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        return in_array($extension, $this->config->allowedExtensions);
    }
    
    /**
     * Get log content with pagination and search
     */
    private function getLogContent(string $filepath, int $page = 1, string $search = ''): array
    {
        if (!file_exists($filepath)) {
            return [];
        }
        
        $lines = file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        // Group log entries
        $logEntries = $this->groupLogEntries($lines);
        
        if (!empty($search)) {
            $logEntries = array_filter($logEntries, function($entry) use ($search) {
                // Search in level, message, details, and raw lines
                $searchInLevel = stripos($entry['level'], $search) !== false;
                $searchInMessage = stripos($entry['message'], $search) !== false;
                $searchInDetails = stripos($entry['details'], $search) !== false;
                $searchInRawLines = false;
                
                // Search in raw lines as well
                foreach ($entry['raw_lines'] as $rawLine) {
                    if (stripos($rawLine, $search) !== false) {
                        $searchInRawLines = true;
                        break;
                    }
                }
                
                return $searchInLevel || $searchInMessage || $searchInDetails || $searchInRawLines;
            });
            $logEntries = array_values($logEntries); // Reset array keys
        }
        
        $totalEntries = count($logEntries);
        $entriesPerPage = 20; // Fewer entries per page since each entry can be multiple lines
        $offset = ($page - 1) * $entriesPerPage;
        
        $pageEntries = array_slice($logEntries, $offset, $entriesPerPage, true);
        
        $formattedEntries = [];
        foreach ($pageEntries as $index => $entry) {
            $formattedEntries[] = [
                'number' => $offset + $index + 1,
                'timestamp' => $entry['timestamp'],
                'level' => $entry['level'],
                'message' => $this->highlightLogMessage($entry['message']),
                'details' => $this->formatLogDetails($entry['details']),
                'raw_lines' => $entry['raw_lines'],
                'line_start' => $entry['line_start'],
                'line_count' => count($entry['raw_lines'])
            ];
        }
        
        return $formattedEntries;
    }
    
    /**
     * Count total lines in log file
     */
    private function countLogLines(string $filepath): int
    {
        if (!file_exists($filepath)) {
            return 0;
        }
        
        $lines = file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $logEntries = $this->groupLogEntries($lines);
        
        return count($logEntries);
    }
    
    /**
     * Group log entries by log headers
     */
    private function groupLogEntries(array $lines): array
    {
        $entries = [];
        $currentEntry = null;
        $lineNumber = 0;
        
        foreach ($lines as $line) {
            $lineNumber++;
            
            // Check if this is a new log entry (starts with LEVEL - TIMESTAMP -->)
            // Also handle lines that start with just LEVEL - TIMESTAMP (without -->)
            if (preg_match('/^(\w+)\s*-\s*(\d{4}-\d{2}-\d{2}\s+\d{2}:\d{2}:\d{2})\s*-->\s*(.+)$/', $line, $matches) ||
                preg_match('/^(\w+)\s*-\s*(\d{4}-\d{2}-\d{2}\s+\d{2}:\d{2}:\d{2})\s*(.*)$/', $line, $matches)) {
                
                // Save previous entry if exists
                if ($currentEntry !== null) {
                    $entries[] = $currentEntry;
                }
                
                // Start new entry
                $currentEntry = [
                    'level' => strtolower(trim($matches[1])),
                    'timestamp' => trim($matches[2]),
                    'message' => trim($matches[3] ?? ''),
                    'details' => '',
                    'raw_lines' => [$line],
                    'line_start' => $lineNumber
                ];
            } else {
                // This is continuation of previous entry
                if ($currentEntry !== null) {
                    $currentEntry['details'] .= ($currentEntry['details'] ? "\n" : '') . $line;
                    $currentEntry['raw_lines'][] = $line;
                } else {
                    // Orphaned line, create a simple entry
                    $entries[] = [
                        'level' => 'info',
                        'timestamp' => '',
                        'message' => $line,
                        'details' => '',
                        'raw_lines' => [$line],
                        'line_start' => $lineNumber
                    ];
                }
            }
        }
        
        // Don't forget the last entry
        if ($currentEntry !== null) {
            $entries[] = $currentEntry;
        }
        
        return $entries;
    }
    
    /**
     * Highlight log message
     */
    private function highlightLogMessage(string $message): string
    {
        $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
        
        // Highlight important keywords
        $keywords = [
            'Exception' => 'text-danger fw-bold',
            'Error' => 'text-danger fw-bold',
            'Fatal' => 'text-danger fw-bold',
            'Warning' => 'text-warning fw-bold',
            'Notice' => 'text-info fw-bold',
            'Deprecated' => 'text-warning',
            'Success' => 'text-success fw-bold',
        ];
        
        foreach ($keywords as $keyword => $class) {
            $pattern = '/\b(' . preg_quote($keyword, '/') . ')\b/i';
            $message = preg_replace($pattern, '<span class="' . $class . '">$1</span>', $message);
        }
        
        return $message;
    }
    
    /**
     * Format log details (stack trace, additional info)
     */
    private function formatLogDetails(string $details): string
    {
        if (empty($details)) {
            return '';
        }
        
        $details = htmlspecialchars($details, ENT_QUOTES, 'UTF-8');
        
        // Highlight file paths
        $details = preg_replace('/([A-Za-z]:[\\\\\/][^:\s]+|\/[^:\s]+\.[a-zA-Z]+)/', '<span class="text-primary">$1</span>', $details);
        
        // Highlight line numbers
        $details = preg_replace('/:(\d+)/', ':<span class="text-info fw-bold">$1</span>', $details);
        
        // Highlight stack trace indicators
        $details = preg_replace('/^(\s*#\d+|\s*at\s+)/m', '<span class="text-muted">$1</span>', $details);
        
        // Highlight function/method names
        $details = preg_replace('/([a-zA-Z_][a-zA-Z0-9_]*::[a-zA-Z_][a-zA-Z0-9_]*|[a-zA-Z_][a-zA-Z0-9_]*\()/', '<span class="text-success">$1</span>', $details);
        
        return $details;
    }
    
    /**
     * Search for specific text in log file
     */
    private function searchInLog(string $filepath, string $query): array
    {
        if (!file_exists($filepath)) {
            return [];
        }
        
        $lines = file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        // Group log entries first
        $logEntries = $this->groupLogEntries($lines);
        $results = [];
        
        foreach ($logEntries as $index => $entry) {
            // Search in level, message, details, and raw lines
            $searchInLevel = stripos($entry['level'], $query) !== false;
            $searchInMessage = stripos($entry['message'], $query) !== false;
            $searchInDetails = stripos($entry['details'], $query) !== false;
            $searchInRawLines = false;
            
            // Search in raw lines as well
            foreach ($entry['raw_lines'] as $rawLine) {
                if (stripos($rawLine, $query) !== false) {
                    $searchInRawLines = true;
                    break;
                }
            }
            
            if ($searchInLevel || $searchInMessage || $searchInDetails || $searchInRawLines) {
                $results[] = [
                    'entry' => $index + 1,
                    'line_start' => $entry['line_start'],
                    'line_count' => count($entry['raw_lines']),
                    'level' => $entry['level'],
                    'timestamp' => $entry['timestamp'],
                    'message' => $this->highlightLogMessage($entry['message']),
                    'details' => $this->formatLogDetails($entry['details']),
                    'matched_in' => [
                        'level' => $searchInLevel,
                        'message' => $searchInMessage,
                        'details' => $searchInDetails,
                        'raw_lines' => $searchInRawLines
                    ]
                ];
            }
        }
        
        return $results;
    }
    
    /**
     * Format log line for display
     */
    private function formatLogLine(string $line): string
    {
        // Escape HTML characters
        $line = htmlspecialchars($line, ENT_QUOTES, 'UTF-8');
        
        // Highlight log levels
        foreach ($this->config->logLevels as $level => $color) {
            $pattern = '/(' . strtoupper($level) . ')/i';
            $replacement = '<span class="log-level" style="color: ' . $color . '; font-weight: bold;">$1</span>';
            $line = preg_replace($pattern, $replacement, $line);
        }
        
        // Highlight timestamps
        $timestampPattern = '/(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})/';
        $line = preg_replace($timestampPattern, '<span class="log-timestamp" style="color: #6c757d;">$1</span>', $line);
        
        return $line;
    }
    
    /**
     * Extract log level from line
     */
    private function extractLogLevel(string $line): string
    {
        if (preg_match('/^\w+ - \d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2} --> (.+?)/', $line, $matches)) {
            return strtolower(trim($matches[1]));
        }
        
        foreach ($this->config->logLevels as $level => $color) {
            if (stripos($line, strtoupper($level)) !== false) {
                return $level;
            }
        }
        
        return 'info';
    }
    
    /**
     * Extract timestamp from log line
     */
    private function extractTimestamp(string $line): string
    {
        if (preg_match('/(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})/', $line, $matches)) {
            return $matches[1];
        }
        
        return '';
    }
    
    /**
     * Format file size in human readable format
     */
    private function formatBytes(int $size, int $precision = 2): string
    {
        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = [' bytes', ' KB', ' MB', ' GB', ' TB'];
            
            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        }
        
        return $size . ' bytes';
    }
}