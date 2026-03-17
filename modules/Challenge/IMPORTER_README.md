# Challenge CSV Importer

Fitur importer CSV untuk sinkronisasi data peserta Challenge GenAI dari platform eksternal ke database RuangAI.

## Background

Saat ini proses pendaftaran peserta dialihkan ke platform eksternal (Typeform/Google Form). Akibatnya, banyak peserta yang sudah mendaftar namun belum tercatat di database RuangAI.

Fitur ini memungkinkan:
- Import data peserta dari CSV
- Membuat akun user otomatis untuk peserta baru
- Menyimpan profil lengkap peserta
- Mencatat partisipasi challenge
- Menghindari duplikasi data

## Struktur CSV

File CSV harus memiliki header berikut:

```csv
source,program,fullname,email,whatsapp,birthday,gender,province,city,occupation,work_experience,skill,institution,major,semester,grade,type_of_business,business_duration,education_level,graduation_year,link_business,last_project,wa_group_link,created_at,updated_at,deleted_at
```

### Penjelasan Kolom

| Kolom | Deskripsi | Required | Contoh |
|-------|-----------|----------|--------|
| source | Sumber pendaftaran | Optional | typeform, googleform |
| program | Nama program challenge | **Required** | GenAI Beginner, GenAI Intermediate, GenAI Advanced |
| fullname | Nama lengkap peserta | **Required** | John Doe |
| email | Email peserta (unique) | **Required** | john@example.com |
| whatsapp | Nomor WhatsApp | Optional | 081234567890 |
| birthday | Tanggal lahir (YYYY-MM-DD) | Optional | 1990-01-01 |
| gender | Jenis kelamin | Optional | male, female |
| province | ID provinsi | Optional | 31 |
| city | ID kota/kabupaten | Optional | 3171 |
| occupation | Pekerjaan | Optional | Pelajar/Mahasiswa, Pekerja, dsb |
| work_experience | Pengalaman kerja | Optional | 0-1 tahun, 1-3 tahun, dsb |
| skill | Keahlian | Optional | Python, AI, Machine Learning |
| institution | Institusi pendidikan/perusahaan | Optional | Universitas Indonesia |
| major | Jurusan | Optional | Teknik Informatika |
| semester | Semester (untuk mahasiswa) | Optional | 6 |
| grade | IPK/Grade | Optional | 3.5 |
| type_of_business | Jenis bisnis | Optional | Tech Startup |
| business_duration | Durasi bisnis | Optional | 1-2 tahun |
| education_level | Jenjang pendidikan | Optional | S1, S2, D3, SMA, dsb |
| graduation_year | Tahun lulus | Optional | 2024 |
| link_business | Link bisnis/company | Optional | https://example.com |
| last_project | Proyek terakhir | Optional | AI chatbot |
| wa_group_link | Link grup WhatsApp | Optional | https://chat.whatsapp.com/xxx |
| created_at | Timestamp pendaftaran | Optional | 2026-03-01 10:00:00 |
| updated_at | Timestamp update | Optional | 2026-03-01 10:00:00 |
| deleted_at | Soft delete | Optional | NULL |

## Database Target

### 1. Table: `users`
Untuk akun login user.

**Mapping:**
- fullname → name
- email → email
- whatsapp → phone
- created_at → created_at
- updated_at → updated_at

**Logic:**
- Jika email sudah ada, gunakan user_id yang sudah ada (tidak membuat user baru)
- Password default untuk user baru: `122333!`
- Role default: role_id = 2 (user biasa)
- Source: `csv_import`

### 2. Table: `user_profiles`
Untuk profil lengkap user.

**Mapping:** Semua field profil dari CSV

**Konversi Khusus:**
- `province` (ID) → Nama provinsi dari tabel `reg_provinces`
- `city` (ID) → Nama kota dari tabel `reg_regencies`

**Logic:**
- Jika profil sudah ada untuk user_id tersebut, maka **update**
- Jika belum ada, maka **insert** baru

### 3. Table: `challenge_alibaba`
Untuk mencatat partisipasi challenge.

**Mapping:**
- user_id → users.id
- challenge_id → mapping dari program
- fullname → fullname
- email → email
- whatsapp → whatsapp
- created_at → created_at
- updated_at → updated_at

**Konversi Program:**
| Program CSV | challenge_id |
|-------------|--------------|
| GenAI Beginner | 1 |
| GenAI Intermediate | 2 |
| GenAI Advanced | 3 |

**Logic:**
- Hindari duplikasi: jika user sudah terdaftar di challenge yang sama, skip insert
- Status default: `registered`

## Cara Penggunaan

### 1. Akses Halaman Importer
```
/admin/challenge/importer
```

### 2. Download Template CSV
Klik tombol "Download Template" untuk mendapatkan template CSV dengan format yang benar.

### 3. Isi Data CSV
- Buka template di Excel/Google Sheets
- Isi data sesuai kolom yang tersedia
- Pastikan format email valid
- Pastikan program sesuai dengan mapping yang ada

### 4. Upload & Process
- Pilih file CSV yang sudah diisi
- Klik "Upload & Process"
- Tunggu proses selesai

### 5. Lihat Hasil
Sistem akan menampilkan:
- Jumlah user baru yang dibuat
- Jumlah user existing yang digunakan kembali
- Jumlah baris yang gagal (jika ada)
- Detail error untuk baris yang gagal

## Features

### ✅ Transaction Safety
- Setiap baris diproses dalam transaction terpisah
- Jika terjadi error, hanya baris tersebut yang rollback
- Baris lainnya tetap berhasil diimport

### ✅ Duplicate Prevention
- Email yang sudah ada tidak akan dibuat ulang
- User yang sudah terdaftar di challenge yang sama akan di-skip
- Profil user akan di-update dengan data terbaru

### ✅ Data Validation
- Validasi format email
- Validasi program/challenge_id
- Validasi file CSV (format, size, extension)

### ✅ Phone Number Normalization
- Otomatis convert 08xxx → 628xxx
- Hapus karakter non-numeric
- Format ke standar internasional

### ✅ Province & City Conversion
- Convert ID provinsi ke nama provinsi
- Convert ID kota ke nama kota
- Data disimpan sebagai nama, bukan ID

### ✅ Error Handling
- Setiap error dicatat di log
- Error message detail untuk debugging
- Summary error ditampilkan ke user

### ✅ Logging
- Log setiap import activity
- Log error dengan detail baris dan email
- Log summary hasil import

## Error Handling

### Common Errors

1. **Email kosong**
   ```
   Email kosong
   ```

2. **Format email tidak valid**
   ```
   Format email tidak valid
   ```

3. **Program tidak dikenal**
   ```
   Program 'GenAI Expert' tidak dikenal
   ```

4. **Gagal membuat user**
   ```
   Gagal membuat user baru
   ```

### Melihat Log Error

Log disimpan di:
```
writable/logs/log-[tanggal].log
```

Format log:
```
ERROR - [timestamp] --> CSV Import Error - Row 15: Format email tidak valid
INFO - [timestamp] --> CSV Import Summary - Imported: 120, Existing: 45, Failed: 3
```

## Best Practices

1. **Validasi Data Sebelum Import**
   - Pastikan email valid dan tidak ada duplikat dalam CSV
   - Pastikan program sesuai dengan mapping
   - Cek format tanggal (YYYY-MM-DD)

2. **Backup Database**
   - Lakukan backup database sebelum import data dalam jumlah besar
   - Gunakan staging environment untuk testing

3. **Test dengan Sample Data**
   - Test dengan beberapa baris data dulu
   - Verifikasi hasil import di database
   - Baru import data lengkap

4. **Monitor Log**
   - Periksa log setelah import
   - Analisa error yang terjadi
   - Perbaiki data dan re-import jika perlu

## API Endpoints

### GET /admin/challenge/importer
Menampilkan halaman upload form

### POST /admin/challenge/importer/process
Memproses file CSV yang diupload

**Parameters:**
- `csv_file` (file, required): File CSV yang akan diimport

**Response:**
- Success: Redirect dengan flash message success
- Warning: Redirect dengan flash message warning (ada error tapi sebagian berhasil)
- Error: Redirect dengan flash message error

### GET /admin/challenge/importer/download-template
Download template CSV kosong

**Response:**
- File CSV dengan header dan sample data

## Technical Details

### File Structure
```
modules/Challenge/
├── Controllers/
│   └── Importer.php          # Main controller
├── Views/
│   └── importer/
│       └── index.php          # Upload form view
└── Config/
    └── Routes.php             # Routes configuration
```

### Dependencies
- CodeIgniter 4
- PHP 7.4+
- MySQL/MariaDB
- Heroicadmin module (for admin layout)

### Models Used
- `App\Models\UserModel`
- `App\Models\UserProfile`
- `Challenge\Models\ChallengeAlibabaModel`

### Database Tables
- `users`
- `user_profiles`
- `challenge_alibaba`
- `reg_provinces` (reference)
- `reg_regencies` (reference)

## Security Notes

⚠️ **Penting:**
- Fitur ini hanya dapat diakses oleh admin
- Pastikan file CSV bersih dari script/code berbahaya
- Validasi data dilakukan sebelum insert ke database
- Password default harus segera diganti oleh user

## Performance Notes

- Import 1000 baris: ~30-60 detik (tergantung server)
- Max file size: 10MB
- Recommended batch size: 500-1000 rows per file
- Untuk import > 1000 rows, pecah menjadi beberapa file

## Future Improvements

Fitur yang bisa ditambahkan:
- [ ] Background job untuk import large file
- [ ] Progress bar untuk tracking import
- [ ] Export hasil import ke Excel
- [ ] Bulk update untuk data existing
- [ ] Dry-run mode untuk preview sebelum import
- [ ] Email notification setelah import selesai
- [ ] Import history log
- [ ] Rollback feature untuk undo import

## Support

Jika ada pertanyaan atau issue, hubungi:
- Development Team: dev@codepolitan.com
- Create issue di repository

---

**Version:** 1.0  
**Last Updated:** March 10, 2026  
**Author:** RuangAI Development Team
