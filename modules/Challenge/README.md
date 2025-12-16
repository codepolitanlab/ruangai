# Challenge Module - WAN Vision Clash

Modul untuk mengelola kompetisi AI Video "RuangAI Challenge — WAN Vision Clash 2025"

## 📋 Struktur Modul

```
modules/Challenge/
├── Config/
│   └── Challenge.php              # Konfigurasi kompetisi (tanggal, hadiah, rules)
├── Controllers/
│   └── Submissions.php            # Admin controller untuk manage submissions
├── Database/
│   └── Migrations/
│       └── 2025-12-14-000001_CreateChallengeAlibabaTable.php
├── Models/
│   └── ChallengeAlibabaModel.php  # Model untuk tabel challenge_alibaba
├── Validation/
│   └── ChallengeRules.php         # Custom validation rules
├── Views/
│   └── submissions/
│       ├── index.php              # List submissions (admin)
│       └── detail.php             # Detail submission (admin)
└── Helpers/
    └── challenge_helper.php       # Helper functions
```

## 🗄️ Database Schema

Tabel: `challenge_alibaba`

| Field | Type | Description |
|-------|------|-------------|
| id | INT | Primary key |
| user_id | INT | Foreign key ke users table |
| challenge_id | VARCHAR(50) | ID challenge (default: wan-vision-clash-2025) |
| twitter_post_url | VARCHAR(500) | URL post Twitter/X |
| video_title | VARCHAR(255) | Judul video |
| video_description | TEXT | Deskripsi video |
| team_members | TEXT | JSON array team members |
| prompt_file | VARCHAR(255) | Path file prompt (PDF/TXT) |
| params_file | VARCHAR(255) | Path file params (JSON) |
| assets_list_file | VARCHAR(255) | Path file assets list (TXT) |
| alibaba_screenshot | VARCHAR(255) | Path screenshot Alibaba Cloud |
| twitter_follow_screenshot | VARCHAR(255) | Path screenshot follow Twitter |
| ethical_statement_agreed | TINYINT(1) | Persetujuan etika (0/1) |
| admin_notes | TEXT | Catatan admin |
| status | ENUM | Status: pending, validated, approved, rejected |
| submitted_at | TIMESTAMP | Tanggal submit |
| created_at | TIMESTAMP | |
| updated_at | TIMESTAMP | |
| deleted_at | TIMESTAMP | Soft delete |

## 🚀 Instalasi

### 1. Jalankan Migration

```bash
php spark migrate -n Challenge
```

### 2. Buat direktori upload

```bash
mkdir -p writable/uploads/challenge
chmod -R 755 writable/uploads/challenge
```

### 3. Load Helper (optional, jika belum auto-load)

Di `app/Config/Autoload.php`:

```php
public $helpers = ['challenge'];
```

## 📝 Penggunaan

### Public Form Submission

**URL:** `/challenge/submit`

Form multi-step untuk submit video challenge:
1. **Step 1:** Video info & team members
2. **Step 2:** Upload files (prompt, params, screenshots)
3. **Step 3:** Review & ethical agreement

**Controller:** `App\Pages\challenge\submit\PageController`

### Admin Panel

**URL:** `/challenge/submissions`

Fitur admin:
- List semua submissions dengan DataTables
- Filter by status (pending, validated, approved, rejected)
- Detail submission dengan preview files
- Action: Validate, Approve, Reject
- Export CSV
- Download uploaded files

**Controller:** `Challenge\Controllers\Submissions`

## 🔧 Konfigurasi

Edit `modules/Challenge/Config/Challenge.php`:

```php
// Event dates
public string $registrationStart = '2025-12-17 17:00:00';
public string $registrationEnd = '2026-01-31 23:59:59';

// File upload settings
public int $maxFileSize = 5242880; // 5MB

// Team settings
public int $maxTeamMembers = 3;

// Prize configuration
public array $prizes = [...];
```

## ✅ Validation Rules

### Twitter URL Format
```php
twitter_url_format($url)
```
Memvalidasi format URL Twitter/X post: `https://twitter.com/username/status/123456`

### Team Members JSON
```php
team_members_json($json)
```
Validasi:
- Max 3 members
- Setiap member punya name & email
- Email tidak duplikat

### JSON Params Structure
```php
json_params_structure($filePath)
```
Validasi file params.json:
- Format JSON valid
- Memiliki field 'model' dan 'version'
- Model harus mengandung 'wan'

### One Submission Per User
```php
one_submission_per_user($userId)
```
Cek user hanya punya 1 submission aktif (status != rejected)

## 📊 Model Methods

### ChallengeAlibabaModel

```php
// Get submission dengan user info
$model->getWithUserInfo($id);

// Get by status
$model->getByStatus('pending');

// Get pending validations
$model->getPendingValidation();

// Check active submission
$model->hasActiveSubmission($userId);

// Update status
$model->updateStatus($id, 'approved', 'Optional notes');

// Get team members as array
$model->getTeamMembersArray($id);
```

## 🛠️ Helper Functions

```php
// Format team members JSON ke HTML
format_team_members($json);

// Generate status badge
challenge_status_badge('pending');

// Get file icon
challenge_file_icon($filename);

// Get upload path
challenge_upload_path($userId);

// Ensure directory exists
ensure_upload_directory($userId);
```

## 📂 File Storage

Files disimpan di: `writable/uploads/challenge/{user_id}/`

Structure:
```
writable/uploads/challenge/
└── {user_id}/
    ├── {random_name}.pdf      # Prompt file
    ├── {random_name}.json     # Params file
    ├── {random_name}.txt      # Assets list
    ├── {random_name}.jpg      # Alibaba screenshot
    └── {random_name}.png      # Twitter screenshot
```

## 🔐 Security

1. **Authentication:** Semua endpoint menggunakan `Heroic->checkToken()`
2. **File Upload:** Validasi extension & size
3. **Admin Panel:** Extend `AdminController` (role-based access)
4. **File Download:** Via controller dengan permission check
5. **SQL Injection:** Protected by Query Builder
6. **XSS:** Auto-escaped views with `esc()`

## 🎯 Workflow

### User Flow
1. User login → akses `/challenge/submit`
2. Check registration period & existing submission
3. Fill form (3 steps)
4. Upload required files
5. Agree ethical statement
6. Submit → status: `pending`

### Admin Flow
1. Admin akses `/challenge/submissions`
2. Filter by status
3. View detail submission
4. **Tahap 0 - Validation:**
   - Cek link Twitter valid
   - Cek files lengkap
   - Cek params menggunakan WAN
   - Status → `validated`
5. **Tahap 1 - Approval:**
   - Juri review
   - Status → `approved` / `rejected`
6. Export results

## 📱 API Endpoints

### Public

```
GET  /challenge/submit/data          # Get form data & config
POST /challenge/submit/postSubmit    # Submit form
```

### Admin

```
GET  /challenge/submissions                    # List (DataTables)
GET  /challenge/submissions/detail/{id}        # Detail
POST /challenge/submissions/approve/{id}       # Approve
POST /challenge/submissions/reject/{id}        # Reject
POST /challenge/submissions/validate/{id}      # Validate
POST /challenge/submissions/bulkApprove        # Bulk approve
GET  /challenge/submissions/download/{id}/{type} # Download file
GET  /challenge/submissions/export             # Export CSV
```

## 🧪 Testing

### Test Submission Flow

1. Buat user test
2. Akses `/challenge/submit`
3. Fill form dengan data valid
4. Upload files (gunakan file dummy)
5. Verify submission masuk database

### Test Admin Panel

1. Login sebagai admin
2. Akses `/challenge/submissions`
3. Test filter by status
4. Test approve/reject
5. Test download files

## 📌 Todo / Future Improvements

- [ ] Add scoring system untuk juri
- [ ] Integrate dengan Alibaba API untuk auto-verify WAN usage
- [ ] Add public leaderboard
- [ ] Email notification untuk status changes
- [ ] Add voting system untuk People's Choice
- [ ] Generate certificate untuk pemenang
- [ ] Add analytics dashboard
- [ ] Implement rate limiting untuk submission

## 🐛 Troubleshooting

### Migration Error

```bash
# Rollback migration
php spark migrate:rollback -n Challenge

# Re-run migration
php spark migrate -n Challenge
```

### File Upload Error

Check permissions:
```bash
chmod -R 755 writable/uploads/challenge
chown -R www-data:www-data writable/uploads/challenge
```

### Module Not Found

Check `app/Config/Autoload.php`:
```php
public $psr4 = [
    'Challenge' => ROOTPATH . 'modules/Challenge',
];
```

## 📞 Support

Untuk pertanyaan atau issue, hubungi tim developer RuangAI.

---

**Version:** 1.0.0  
**Last Updated:** 14 Desember 2025  
**Author:** RuangAI Development Team
