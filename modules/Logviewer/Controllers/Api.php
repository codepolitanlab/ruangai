<?php

namespace Logviewer\Controllers;

use App\Controllers\BaseController;
use Logviewer\Config\Logviewer as LogviewerConfig;

/**
 * API Controller for Logviewer module
 * Provides JSON endpoints for AJAX requests
 */
class Api extends BaseController
{
    protected LogviewerConfig $config;
    
    public function __construct()
    {
        $this->config = new LogviewerConfig();
    }
    
    /**
     * Get dashboard statistics
     */
    public function dashboard()
    {
        helper('logviewer');
        
        $stats = [
            'total_files' => 0,
            'total_size' => 0,
            'recent_errors' => 0,
            'recent_warnings' => 0,
            'latest_logs' => []
        ];
        
        $logPath = $this->config->logPath;
        
        if (is_dir($logPath)) {
            $files = glob($logPath . '*.log');
            $stats['total_files'] = count($files);
            
            // Calculate total size
            foreach ($files as $file) {
                $stats['total_size'] += filesize($file);
            }
            
            // Get recent logs and count errors/warnings
            $recentLogs = get_recent_logs($logPath, 20);
            $stats['latest_logs'] = array_slice($recentLogs, 0, 5);
            
            foreach ($recentLogs as $log) {
                if ($log['level'] === 'error' || $log['level'] === 'critical') {
                    $stats['recent_errors']++;
                } elseif ($log['level'] === 'warning') {
                    $stats['recent_warnings']++;
                }
            }
        }
        
        // Format file size
        $stats['total_size_formatted'] = $this->formatBytes($stats['total_size']);
        
        return $this->response->setJSON($stats);
    }
    
    /**
     * Get log level statistics for a specific file
     */
    public function fileStats($filename)
    {
        if (!$this->isValidLogFile($filename)) {
            return $this->response->setJSON(['error' => 'Invalid log file']);
        }
        
        helper('logviewer');
        
        $filepath = $this->config->logPath . $filename;
        $stats = get_log_statistics($filepath);
        
        return $this->response->setJSON($stats);
    }
    
    /**
     * Get recent activity across all log files
     */
    public function recentActivity()
    {
        helper('logviewer');
        
        $recentLogs = get_recent_logs($this->config->logPath, 50);
        
        return $this->response->setJSON([
            'logs' => $recentLogs,
            'count' => count($recentLogs)
        ]);
    }
    
    /**
     * Clean old log files
     */
    public function cleanOld()
    {
        helper('logviewer');
        
        $retentionDays = (int) ($this->request->getPost('retention_days') ?? 30);
        $deletedFiles = clean_old_logs($this->config->logPath, $retentionDays);
        
        return $this->response->setJSON([
            'success' => true,
            'deleted_files' => $deletedFiles,
            'count' => count($deletedFiles),
            'message' => 'Successfully cleaned ' . count($deletedFiles) . ' old log files'
        ]);
    }
    
    /**
     * Export log file to CSV
     */
    public function exportCsv($filename)
    {
        if (!$this->isValidLogFile($filename)) {
            return $this->response->setJSON(['error' => 'Invalid log file']);
        }
        
        helper('logviewer');
        
        try {
            $filepath = $this->config->logPath . $filename;
            $csvPath = export_logs_csv($filepath, WRITEPATH . 'uploads/' . pathinfo($filename, PATHINFO_FILENAME) . '.csv');
            
            return $this->response->setJSON([
                'success' => true,
                'download_url' => base_url('writable/uploads/' . basename($csvPath)),
                'message' => 'CSV export completed successfully'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => 'Export failed: ' . $e->getMessage()
            ]);
        }
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