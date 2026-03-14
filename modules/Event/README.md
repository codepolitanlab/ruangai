# Event Module

Modul manajemen event untuk RuangAI dengan dukungan event online, offline, dan hybrid.

## 📋 Fitur Utama

### 1. Manajemen Event
- ✅ CRUD lengkap untuk event
- ✅ Support 3 tipe event: Online, Offline, Hybrid
- ✅ Kategori event: Workshop, Seminar, Webinar, Conference, Meetup, Training, Bootcamp, Competition
- ✅ Status event: Draft, Published, Ongoing, Completed, Cancelled
- ✅ Kuota peserta (unlimited atau terbatas)
- ✅ Event gratis atau berbayar
- ✅ Upload thumbnail dan banner
- ✅ Auto-generate slug dari title

### 2. Manajemen Peserta
- ✅ Many-to-many relationship dengan users
- ✅ Status kehadiran: Registered, Attended, Absent, Cancelled
- ✅ Check-in/check-out time tracking
- ✅ Tambah peserta manual atau self-registration
- ✅ Validasi kuota peserta
- ✅ Export data peserta

### 3. Multi-Sesi Event
- ✅ Event dapat memiliki multiple sessions
- ✅ Informasi speaker per sesi (nama, bio, foto)
- ✅ Pengaturan urutan sesi
- ✅ Waktu mulai/selesai per sesi

### 4. Integrasi Sertifikat
- ✅ Integrasi dengan modul Certificate
- ✅ Auto-issue certificate untuk peserta yang hadir
- ✅ Validasi kehadiran sebelum terbit sertifikat
- ✅ Link ke detail sertifikat

## 🗄️ Struktur Database

### Table: `scholarship_events`
```sql
- id (INT, PK, AUTO_INCREMENT)
- title (VARCHAR 255) - Judul event
- slug (VARCHAR 255, UNIQUE) - URL-friendly identifier
- description (TEXT) - Deskripsi lengkap
- event_type (ENUM: online, offline, hybrid)
- category (VARCHAR 50) - workshop, seminar, dll
- start_date, end_date (DATETIME)
- registration_start, registration_end (DATETIME)
- max_participants (INT, nullable) - null = unlimited
- is_free (TINYINT) - 0/1
- price (DECIMAL 10,2)
- currency (VARCHAR 3) - IDR, USD, dll

# Location (untuk offline/hybrid)
- venue_name (VARCHAR 255)
- venue_address (TEXT)
- city, province, country (VARCHAR)

# Online meeting (untuk online/hybrid)
- meeting_platform (VARCHAR 50) - Zoom, Google Meet, dll
- meeting_url (VARCHAR 500)
- meeting_id (VARCHAR 100)
- meeting_password (VARCHAR 100)

# Media
- thumbnail (VARCHAR 255)
- banner (VARCHAR 255)

# Organizer
- organizer_name (VARCHAR 255)
- organizer_email (VARCHAR 255)
- organizer_phone (VARCHAR 20)
- created_by (INT, FK to users)

# Certificate
- has_certificate (TINYINT)
- certificate_template (VARCHAR 50)
- attendance_required (TINYINT) - Wajib hadir untuk sertifikat

# Status
- status (ENUM: draft, published, ongoing, completed, cancelled)
- is_active (TINYINT)
- created_at, updated_at (DATETIME)
```

### Table: `event_participants`
```sql
- id (INT, PK, AUTO_INCREMENT)
- event_id (INT, FK to events, CASCADE)
- user_id (INT, FK to users, CASCADE)
- registration_date (DATETIME)
- attendance_status (ENUM: registered, attended, absent, cancelled)
- check_in_time (DATETIME, nullable)
- check_out_time (DATETIME, nullable)
- certificate_issued (TINYINT) - 0/1
- certificate_id (INT, FK to certificates, nullable)
- notes (TEXT)
- created_at, updated_at (DATETIME)
```

### Table: `event_sessions`
```sql
- id (INT, PK, AUTO_INCREMENT)
- event_id (INT, FK to events, CASCADE)
- session_name (VARCHAR 255)
- session_description (TEXT)
- speaker_name (VARCHAR 255)
- speaker_bio (TEXT)
- speaker_photo (VARCHAR 255)
- start_time, end_time (DATETIME)
- session_order (INT) - Urutan sesi
- is_active (TINYINT)
- created_at, updated_at (DATETIME)
```

## 📁 Struktur File

```
modules/Event/
├── Config/
│   ├── Routes.php          # Route definitions
│   └── Event.php           # Configuration
├── Controllers/
│   └── Event.php           # Main controller (CRUD + participants + sessions)
├── Database/
│   └── Migrations/
│       └── 2025-12-30-000000_CreateEventTables.php
├── Entries/
│   └── event.yml           # Entry configuration untuk auto-CRUD
├── Models/
│   ├── EventModel.php
│   └── EventParticipantModel.php
├── Views/
│   ├── participants.php    # Halaman daftar peserta
│   └── sessions.php        # Halaman daftar sesi
└── README.md
```

## 🚀 Instalasi

### 1. Jalankan Migration
```bash
php spark migrate -n Event
```

### 2. Update Config Autoload
Tambahkan namespace Event ke `app/Config/Autoload.php`:
```php
public $psr4 = [
    // ...
    'Event' => ROOTPATH . 'modules/Event',
];
```

### 3. Load Routes
Pastikan routes Event di-load di `app/Config/Routes.php`:
```php
// Load Event routes
if (file_exists(ROOTPATH . 'modules/Event/Config/Routes.php')) {
    require_once ROOTPATH . 'modules/Event/Config/Routes.php';
}
```

## 📖 Penggunaan

### Akses Admin Panel
```
https://your-domain.com/heroic/event
```

### Menu CRUD Event:
- **List Events**: `/heroic/event`
- **Tambah Event**: `/heroic/event/add`
- **Edit Event**: `/heroic/event/edit/{id}`
- **Hapus Event**: `/heroic/event/delete/{id}`

### Menu Peserta:
- **Daftar Peserta**: `/heroic/event/participants/{eventId}`
- **Tambah Peserta**: POST `/heroic/event/participants/add/{eventId}`
- **Update Kehadiran**: POST `/heroic/event/participants/attendance/{participantId}`
- **Terbitkan Sertifikat**: POST `/heroic/event/participants/certificate/{participantId}`

### Menu Sesi:
- **Daftar Sesi**: `/heroic/event/sessions/{eventId}`

## 🎯 Contoh Kode

### Mendapatkan Upcoming Events
```php
$eventModel = new \Event\Models\EventModel();
$upcomingEvents = $eventModel->getUpcomingEvents(10);
```

### Cek Apakah Event Full
```php
$eventModel = new \Event\Models\EventModel();
$isFull = $eventModel->isFull($eventId);
```

### Cek Registrasi Masih Buka
```php
$eventModel = new \Event\Models\EventModel();
$isOpen = $eventModel->isRegistrationOpen($eventId);
```

### Tambah Peserta Programmatically
```php
$participantModel = new \Event\Models\EventParticipantModel();
$data = [
    'event_id' => 1,
    'user_id' => 123,
    'registration_date' => date('Y-m-d H:i:s'),
    'attendance_status' => 'registered',
];
$participantModel->insert($data);
```

### Mark Attendance
```php
$participantModel = new \Event\Models\EventParticipantModel();
$participantModel->markAttendance($participantId, true); // attended
```

### Issue Certificate
```php
// Dari controller Event
$this->issueCertificate($participantId);
```

## 🔗 Integrasi dengan Certificate Module

Event modul terintegrasi dengan Certificate module melalui:
1. Field `entity_type = 'event'` dan `entity_id = event.id` di tabel certificates
2. Auto-generate certificate untuk peserta yang hadir
3. Validasi kehadiran sebelum terbit sertifikat (jika attendance_required = 1)

### Alur Issue Certificate:
1. Peserta hadir di event (attendance_status = 'attended')
2. Admin klik tombol "Terbitkan Sertifikat"
3. System validasi:
   - Event punya sertifikat (`has_certificate = 1`)
   - Peserta sudah hadir (jika `attendance_required = 1`)
   - Sertifikat belum pernah diterbitkan
4. System generate cert_code dan insert ke tabel certificates
5. Update event_participants: `certificate_issued = 1`, `certificate_id = X`

## ⚙️ Konfigurasi

Edit `modules/Event/Config/Event.php`:

```php
// Tipe event
public array $eventTypes = [
    'online' => 'Online',
    'offline' => 'Offline',
    'hybrid' => 'Hybrid',
];

// Kategori event
public array $eventCategories = [
    'workshop' => 'Workshop',
    'seminar' => 'Seminar',
    // ... dll
];

// Upload settings
public array $uploadSettings = [
    'thumbnail' => [
        'max_size' => 2048, // KB
        'allowed_types' => ['jpg', 'jpeg', 'png', 'webp'],
        'recommended_size' => '800x600',
    ],
    'banner' => [
        'max_size' => 5120, // KB
        'allowed_types' => ['jpg', 'jpeg', 'png', 'webp'],
        'recommended_size' => '1920x1080',
    ],
];
```

## 📝 Field Validation Rules

Sesuai dengan `event.yml`:
- **title**: required, min 5 chars, max 255 chars
- **slug**: optional, alpha_dash, unique
- **event_type**: required, in_list[online,offline,hybrid]
- **start_date, end_date**: required, valid_date
- **max_participants**: optional, integer, > 0
- **price**: optional, decimal, >= 0

## 🎨 Customization

### Tambah Kategori Event Baru
Edit `modules/Event/Config/Event.php`:
```php
public array $eventCategories = [
    // ... existing
    'hackathon' => 'Hackathon',
    'networking' => 'Networking Event',
];
```

Lalu update `modules/Event/Entries/event.yml`:
```yaml
category:
  options:
    # ... existing
    hackathon: Hackathon
    networking: Networking Event
```

### Tambah Field Custom
1. Tambahkan kolom di migration
2. Tambahkan field di `EventModel::$allowedFields`
3. Tambahkan field di `event.yml`

## 🔐 Authorization

Pastikan hanya admin yang dapat akses:
```php
// Di BaseController atau Filter
if (!session()->has('admin_logged_in')) {
    return redirect()->to('/login');
}
```

## 📊 Reporting & Statistics

Model EventModel menyediakan helper methods:
- `getEventsWithParticipantCount()` - Event dengan jumlah peserta
- `getUpcomingEvents()` - Event yang akan datang
- `getOngoingEvents()` - Event sedang berlangsung
- `isFull()` - Cek kuota penuh
- `isRegistrationOpen()` - Cek registrasi masih buka

Model EventParticipantModel:
- `getParticipantsWithUser()` - Peserta dengan info user
- `isUserRegistered()` - Cek user sudah daftar
- `getAttendedParticipants()` - Peserta yang hadir
- `getEligibleForCertificate()` - Peserta eligible untuk sertifikat

## 🐛 Troubleshooting

### Migration Gagal
```bash
# Rollback
php spark migrate:rollback -n Event

# Re-run
php spark migrate -n Event
```

### Routes Tidak Terbaca
Pastikan `modules/Event/Config/Routes.php` di-load di `app/Config/Routes.php`

### Upload File Gagal
Cek permission folder `public/uploads/events/`:
```bash
chmod -R 755 public/uploads/events/
```

## 📚 Dependencies

- CodeIgniter 4
- Heroicadmin Entry System
- Certificate Module (untuk sertifikat)
- Bootstrap 5 (untuk UI)
- Alpine.js (optional, untuk interaktivitas)

## 🚧 Roadmap / TODO

- [ ] Public registration form (user self-register)
- [ ] Email notification (reminder, confirmation, certificate)
- [ ] QR code untuk check-in
- [ ] Export peserta ke Excel/PDF
- [ ] Analytics dashboard (statistik event)
- [ ] Review & rating system
- [ ] Integration dengan payment gateway
- [ ] Calendar view untuk event
- [ ] Recurring events
- [ ] Waitlist untuk event penuh

## 📝 License

MIT License - RuangAI Event Module

## 👥 Contributor

- Development Team RuangAI
- Heroicadmin Framework

---

Untuk pertanyaan atau issue, silakan hubungi tim development.
