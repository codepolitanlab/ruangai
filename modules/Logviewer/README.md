# Logviewer Module

Modul untuk melihat dan mengelola file log aplikasi CodeIgniter 4 dengan interface yang user-friendly.

## Fitur

### ✅ Fitur Utama
- **Daftar File Log**: Menampilkan semua file log dengan informasi ukuran, jumlah baris, dan tanggal modifikasi
- **Tampilan Log Terstruktur**: Interface yang mudah dibaca dengan format per-entry, bukan per-baris
- **Log Entry Grouping**: Setiap log entry ditampilkan dalam satu blok dengan header, message, dan details
- **Pagination**: Navigasi halaman untuk file log yang besar (20 entries per halaman)
- **Pencarian**: Fitur search untuk mencari keyword tertentu dalam log entries
- **Download**: Download file log individual
- **Hapus File**: Hapus file log yang tidak diperlukan
- **Clear All**: Hapus semua file log sekaligus

### 🎨 Fitur Tampilan
- **Entry-based Display**: Setiap log entry (CRITICAL, ERROR, WARNING, dll) ditampilkan dalam satu blok terpisah
- **Auto-expand Errors**: Log dengan level ERROR, CRITICAL, atau EMERGENCY otomatis diperluas
- **Collapsible Details**: Detail error seperti stack trace dapat di-collapse/expand
- **Color-coded Levels**: Border dan background color berdasarkan level log
- **Raw Line View**: Opsi untuk melihat format log asli per entry
- **Bootstrap Integration**: Menggunakan Bootstrap untuk styling yang konsisten

### 🔧 Fitur Lanjutan
- **API Endpoints**: REST API untuk integrasi dengan aplikasi lain
- **Log Statistics**: Statistik level log dan aktivitas
- **Auto Refresh**: Refresh otomatis untuk halaman log terbaru
- **CSV Export**: Export log ke format CSV
- **Old Log Cleanup**: Pembersihan log lama otomatis
- **Smart Parsing**: Parsing format log CodeIgniter dengan pengelompokan yang cerdas

## Instalasi dan Penggunaan

### 1. Akses Module
Modul ini sudah siap digunakan. Akses melalui:
```
https://yourdomain.com/ruangpanel/logviewer
```

### 3. Struktur File

**Tampilan Terstruktur per Entry:**
- Setiap log entry ditampilkan dalam satu blok card
- Header menampilkan: nomor entry, level badge, timestamp, dan range baris
- Message ditampilkan dengan highlighting keyword penting
- Details (stack trace, informasi tambahan) dapat di-collapse/expand
- Raw lines dapat ditampilkan untuk debugging

**Auto-expand untuk Error:**
- Log dengan level ERROR, CRITICAL, atau EMERGENCY otomatis terbuka detail-nya
- Memudahkan identifikasi masalah dengan cepat

**Contoh tampilan:**
```
#1 [ERROR] 2025-10-15 08:22:27                Lines: 1-3
[Exception] Call to undefined method User::getName()
▼ Details:
    Stack trace:
    #0 /app/Controllers/User.php:25
    #1 /app/Controllers/Home.php:15
```
```
modules/Logviewer/
├── Config/
│   ├── Logviewer.php     # Konfigurasi module
│   └── Routes.php        # Routing
├── Controllers/
│   ├── Logviewer.php     # Controller utama
│   └── Api.php           # API controller
├── Views/
│   ├── index.php         # Halaman daftar log
│   └── view.php          # Halaman tampilan log
└── Helpers/
    └── logviewer_helper.php  # Helper functions
```

### 3. Konfigurasi

Konfigurasi dapat diubah di file `Config/Logviewer.php`:

```php
<?php
namespace Logviewer\Config;

class Logviewer extends BaseConfig
{
    // Path folder log
    public string $logPath = WRITEPATH . 'logs/';
    
    // Ekstensi file yang diizinkan
    public array $allowedExtensions = ['log'];
    
    // Jumlah baris per halaman
    public int $linesPerPage = 20; // Sekarang dalam entries, bukan lines
    
    // Konfigurasi warna untuk level log
    public array $logLevels = [
        'emergency' => '#dc3545',
        'alert'     => '#fd7e14',
        'critical'  => '#dc3545',
        'error'     => '#dc3545',
        'warning'   => '#ffc107',
        'notice'    => '#17a2b8',
        'info'      => '#17a2b8',
        'debug'     => '#6c757d',
    ];
}
```

## API Endpoints

Module ini menyediakan beberapa API endpoints:

### Daftar File Log
```
GET /ruangpanel/logviewer/api/files
```

### Konten Log dengan Pagination
```
GET /ruangpanel/logviewer/api/content/{filename}?page=1&search=keyword
```

### Pencarian dalam Log
```
GET /ruangpanel/logviewer/api/search/{filename}?q=keyword
```

### Dashboard Statistics
```
GET /ruangpanel/logviewer/api/dashboard
```

### Statistik File
```
GET /ruangpanel/logviewer/api/file-stats/{filename}
```

### Aktivitas Terbaru
```
GET /ruangpanel/logviewer/api/recent-activity
```

### Export ke CSV
```
GET /ruangpanel/logviewer/api/export-csv/{filename}
```

### Pembersihan Log Lama
```
POST /ruangpanel/logviewer/api/clean-old
Content-Type: application/json
{
    "retention_days": 30
}
```

## Helper Functions

Module ini menyediakan beberapa helper functions yang dapat digunakan:

```php
helper('logviewer');

// Parse baris log CodeIgniter
$parsed = parse_codeigniter_log_line($logLine);

// Highlight keywords dalam log
$highlighted = highlight_log_keywords($message);

// Dapatkan statistik file log
$stats = get_log_statistics($filepath);

// Filter log berdasarkan level
$errorLogs = filter_logs_by_level($lines, 'error');

// Filter log berdasarkan tanggal
$todayLogs = filter_logs_by_date($lines, '2025-10-15');

// Dapatkan log terbaru dari semua file
$recentLogs = get_recent_logs($logPath, 50);

// Bersihkan log lama
$deletedFiles = clean_old_logs($logPath, 30);

// Export ke CSV
$csvPath = export_logs_csv($logFilePath);
```

## Screenshots

### Halaman Daftar Log
- Menampilkan semua file log dengan metadata
- Tombol aksi: View, Download, Delete
- Informasi: ukuran file, jumlah baris, tanggal modifikasi

### Halaman Tampilan Log
- Interface bersih untuk membaca log entries
- Setiap entry dalam card terpisah dengan header, message, dan details
- Auto-expand untuk error/critical entries
- Pagination untuk navigasi antar halaman
- Search box untuk pencarian dalam entries
- Toggle raw lines untuk melihat format log asli
- Color coding berdasarkan level log
- Collapsible details untuk stack trace dan informasi tambahan

## Keamanan

- Module hanya dapat diakses melalui admin panel
- Validasi file untuk mencegah akses ke file non-log
- Sanitasi input untuk pencegahan XSS
- Pembatasan ekstensi file yang diizinkan

## Tips Penggunaan

1. **Pencarian Efektif**: Gunakan keyword spesifik seperti "ERROR", "exception", atau nama class
2. **Monitoring Real-time**: Gunakan auto-refresh pada halaman log terbaru
3. **Maintenance**: Gunakan fitur "Clear All" secara berkala untuk mengelola ukuran log
4. **Export Data**: Gunakan export CSV untuk analisis lebih lanjut
5. **API Integration**: Gunakan API endpoints untuk monitoring otomatis

## Troubleshooting

### File Log Tidak Muncul
- Pastikan folder `writable/logs/` memiliki permission yang benar
- Periksa konfigurasi `$logPath` di Config/Logviewer.php

### Error Permission Denied
- Pastikan web server memiliki akses baca ke folder log
- Periksa ownership dan permission folder writable

### Log Tidak Ter-parse dengan Benar
- Module ini di-optimasi untuk format log CodeIgniter 4
- Untuk format log custom, modifikasi function `parse_codeigniter_log_line()`

## Lisensi

Module ini merupakan bagian dari sistem RuangAI dan mengikuti lisensi yang sama dengan aplikasi utama.