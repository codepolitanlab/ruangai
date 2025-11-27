<?php

/**
 * Logviewer Helper Functions
 * 
 * Helper functions for the Logviewer module
 */

if (!function_exists('format_log_level')) {
    /**
     * Format log level with appropriate styling
     */
    function format_log_level(string $level): string
    {
        $colors = [
            'emergency' => 'danger',
            'alert'     => 'warning',
            'critical'  => 'danger',
            'error'     => 'danger',
            'warning'   => 'warning',
            'notice'    => 'info',
            'info'      => 'info',
            'debug'     => 'secondary',
        ];
        
        $level = strtolower($level);
        $color = $colors[$level] ?? 'secondary';
        
        return '<span class="badge bg-' . $color . '">' . strtoupper($level) . '</span>';
    }
}

if (!function_exists('parse_codeigniter_log_line')) {
    /**
     * Parse CodeIgniter log line format
     * 
     * Expected format: LEVEL - YYYY-MM-DD HH:MM:SS --> Message
     */
    function parse_codeigniter_log_line(string $line): array
    {
        $pattern = '/^(\w+)\s*-\s*(\d{4}-\d{2}-\d{2}\s+\d{2}:\d{2}:\d{2})\s*-->\s*(.+)$/';
        
        if (preg_match($pattern, $line, $matches)) {
            return [
                'level' => strtolower(trim($matches[1])),
                'timestamp' => trim($matches[2]),
                'message' => trim($matches[3]),
                'raw' => $line
            ];
        }
        
        return [
            'level' => 'info',
            'timestamp' => '',
            'message' => $line,
            'raw' => $line
        ];
    }
}

if (!function_exists('highlight_log_keywords')) {
    /**
     * Highlight important keywords in log messages
     */
    function highlight_log_keywords(string $message): string
    {
        $keywords = [
            // Error related
            'error' => 'text-danger',
            'exception' => 'text-danger',
            'fatal' => 'text-danger',
            'fail' => 'text-danger',
            
            // Warning related
            'warning' => 'text-warning',
            'deprecated' => 'text-warning',
            
            // Success related
            'success' => 'text-success',
            'complete' => 'text-success',
            'done' => 'text-success',
            
            // Info related
            'info' => 'text-info',
            'notice' => 'text-info',
        ];
        
        foreach ($keywords as $keyword => $class) {
            $pattern = '/\b(' . preg_quote($keyword, '/') . ')\b/i';
            $message = preg_replace($pattern, '<span class="' . $class . ' fw-bold">$1</span>', $message);
        }
        
        return $message;
    }
}

if (!function_exists('get_log_statistics')) {
    /**
     * Get statistics for a log file
     */
    function get_log_statistics(string $filepath): array
    {
        if (!file_exists($filepath)) {
            return [];
        }
        
        $lines = file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $stats = [
            'total_lines' => count($lines),
            'levels' => [],
            'dates' => [],
            'size' => filesize($filepath)
        ];
        
        foreach ($lines as $line) {
            $parsed = parse_codeigniter_log_line($line);
            
            // Count levels
            $level = $parsed['level'];
            $stats['levels'][$level] = ($stats['levels'][$level] ?? 0) + 1;
            
            // Count dates
            if (!empty($parsed['timestamp'])) {
                $date = date('Y-m-d', strtotime($parsed['timestamp']));
                $stats['dates'][$date] = ($stats['dates'][$date] ?? 0) + 1;
            }
        }
        
        return $stats;
    }
}

if (!function_exists('filter_logs_by_level')) {
    /**
     * Filter log lines by level
     */
    function filter_logs_by_level(array $lines, string $level): array
    {
        return array_filter($lines, function($line) use ($level) {
            $parsed = parse_codeigniter_log_line($line);
            return $parsed['level'] === strtolower($level);
        });
    }
}

if (!function_exists('filter_logs_by_date')) {
    /**
     * Filter log lines by date
     */
    function filter_logs_by_date(array $lines, string $date): array
    {
        return array_filter($lines, function($line) use ($date) {
            $parsed = parse_codeigniter_log_line($line);
            if (empty($parsed['timestamp'])) {
                return false;
            }
            
            $logDate = date('Y-m-d', strtotime($parsed['timestamp']));
            return $logDate === $date;
        });
    }
}

if (!function_exists('get_recent_logs')) {
    /**
     * Get recent log entries from all log files
     */
    function get_recent_logs(string $logPath, int $limit = 50): array
    {
        $allLogs = [];
        
        if (!is_dir($logPath)) {
            return $allLogs;
        }
        
        $files = glob($logPath . '*.log');
        
        foreach ($files as $file) {
            $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            foreach ($lines as $line) {
                $parsed = parse_codeigniter_log_line($line);
                if (!empty($parsed['timestamp'])) {
                    $allLogs[] = [
                        'file' => basename($file),
                        'timestamp' => $parsed['timestamp'],
                        'level' => $parsed['level'],
                        'message' => $parsed['message'],
                        'sort_time' => strtotime($parsed['timestamp'])
                    ];
                }
            }
        }
        
        // Sort by timestamp (newest first)
        usort($allLogs, function($a, $b) {
            return $b['sort_time'] - $a['sort_time'];
        });
        
        return array_slice($allLogs, 0, $limit);
    }
}

if (!function_exists('clean_old_logs')) {
    /**
     * Clean old log files beyond retention days
     */
    function clean_old_logs(string $logPath, int $retentionDays = 30): array
    {
        $deleted = [];
        $cutoffTime = time() - ($retentionDays * 24 * 60 * 60);
        
        if (!is_dir($logPath)) {
            return $deleted;
        }
        
        $files = glob($logPath . '*.log');
        
        foreach ($files as $file) {
            if (filemtime($file) < $cutoffTime) {
                if (unlink($file)) {
                    $deleted[] = basename($file);
                }
            }
        }
        
        return $deleted;
    }
}

if (!function_exists('export_logs_csv')) {
    /**
     * Export log data to CSV format
     */
    function export_logs_csv(string $filepath, string $outputPath = ''): string
    {
        if (!file_exists($filepath)) {
            throw new InvalidArgumentException('Log file not found');
        }
        
        $lines = file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $csvData = [];
        
        // CSV header
        $csvData[] = ['Timestamp', 'Level', 'Message'];
        
        foreach ($lines as $line) {
            $parsed = parse_codeigniter_log_line($line);
            $csvData[] = [
                $parsed['timestamp'],
                strtoupper($parsed['level']),
                $parsed['message']
            ];
        }
        
        if ($outputPath === null) {
            $outputPath = pathinfo($filepath, PATHINFO_FILENAME) . '.csv';
        }
        
        $fp = fopen($outputPath, 'w');
        
        foreach ($csvData as $row) {
            fputcsv($fp, $row);
        }
        
        fclose($fp);
        
        return $outputPath;
    }
}