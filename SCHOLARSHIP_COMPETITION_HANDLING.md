# Dokumentasi: Handling User Kompetisi vs User Beasiswa

## Overview
Sistem kini mendukung 2 jenis user:
1. **User Beasiswa** - Terdaftar di `scholarship_participants` dan `course_students`
2. **User Kompetisi** - Hanya registrasi akun biasa, belum mendaftar beasiswa

## File-file yang Diubah

### 1. Helper Function Baru
📄 **`app/Helpers/scholarship_helper.php`**
Helper function untuk membantu identifikasi dan handle data beasiswa dengan safe null handling.

**Functions:**
- `is_scholarship_participant($user_id)` - Cek apakah user adalah peserta beasiswa
- `get_scholarship_data($user_id)` - Get data beasiswa user dengan null safety
- `is_enrolled_in_course($user_id, $course_id)` - Cek enrollment course
- `get_student_course_data($user_id, $course_id)` - Get data course student
- `scholarship_registration_url()` - Get URL pendaftaran beasiswa

### 2. Controllers yang Diupdate

#### 📄 **`app/Pages/home/PageController.php`**
- ✅ Load scholarship helper
- ✅ Add `is_scholarship_participant` flag ke response
- ✅ Null safety untuk `data['student']`, `event`, `group_comentor`
- ✅ Conditional check sebelum query data beasiswa
- ✅ Update `postVerifyEmail()` dengan null check untuk scholarship_participants

#### 📄 **`app/Pages/courses/PageController.php`**
- ✅ Load scholarship helper
- ✅ Add `is_scholarship_participant` flag
- ✅ Add `scholarship_url` untuk CTA

#### 📄 **`app/Pages/courses/intro/PageController.php`**
- ✅ Load scholarship helper
- ✅ Add flags untuk scholarship participant
- ✅ Null safety untuk `is_expire` check

#### 📄 **`app/Pages/comentor/PageController.php`**
- ✅ Load scholarship helper
- ✅ Early return jika user bukan peserta beasiswa
- ✅ Null check untuk leader data
- ✅ Return empty data structure untuk user kompetisi

#### 📄 **`app/Pages/courses/zoom/PageController.php`**
- ✅ Load scholarship helper
- ✅ Null safety untuk participant data
- ✅ Conditional check sebelum akses property participant

#### 📄 **`app/Pages/courses/intro/live_session/PageController.php`**
- ✅ Load scholarship helper
- ✅ Null safety untuk participant data
- ✅ Proper null checks untuk comentor data

### 3. Component Baru

#### 📄 **`app/Pages/_components/scholarship_cta.php`**
Component reusable untuk menampilkan CTA pendaftaran beasiswa.
- Hanya tampil jika `!data?.is_scholarship_participant`
- Design menarik dengan icon dan button
- Link ke https://ruangai.id

### 4. Templates yang Diupdate

#### 📄 **`app/Pages/home/user.php`**
- ✅ Include scholarship CTA component
- ✅ Conditional rendering untuk expire alert (hanya untuk peserta beasiswa)

#### 📄 **`app/Pages/courses/template.php`**
- ✅ Include scholarship CTA component
- ✅ Show empty state untuk user kompetisi tanpa kelas

#### 📄 **`app/Pages/comentor/template.php`**
- ✅ Include scholarship CTA component
- ✅ Conditional rendering untuk data comentor

## Cara Kerja

### Flow User Beasiswa (Normal)
1. User login → sistem cek `scholarship_participants`
2. `is_scholarship_participant` = true
3. Query data beasiswa berjalan normal
4. Tampilan beasiswa ditampilkan lengkap
5. Tidak ada CTA pendaftaran

### Flow User Kompetisi (Baru)
1. User login → sistem cek `scholarship_participants`
2. `is_scholarship_participant` = false
3. Query data beasiswa di-skip atau return null
4. Tampilan CTA pendaftaran beasiswa muncul
5. Button "Daftar Beasiswa" redirect ke ruangai.id

## Keamanan & Error Handling

### Null Safety Patterns
```php
// ✅ Correct: Check before access
if ($data && isset($data->property)) {
    $value = $data->property;
}

// ✅ Correct: Null coalescing
$value = $participant->program ?? null;

// ✅ Correct: Conditional with null check
$isExpire = ($student && $student->expire_at && $student->expire_at < date('Y-m-d H:i:s'));
```

### Query Patterns
```php
// ✅ LEFT JOIN untuk optional data
->join('scholarship_participants', '...', 'left')

// ✅ Early return untuk user kompetisi
if (!is_scholarship_participant($user_id)) {
    return $this->respond([...]);
}
```

## Testing Checklist

### User Beasiswa (Existing Flow)
- [ ] Homepage load tanpa error
- [ ] Courses page tampil normal
- [ ] Course intro bisa diakses
- [ ] Comentor page untuk role co-mentor
- [ ] Live session bisa diakses
- [ ] Data beasiswa tampil lengkap

### User Kompetisi (New Flow)
- [ ] Homepage load tanpa error
- [ ] CTA beasiswa muncul
- [ ] Courses page tidak error meski kosong
- [ ] Course intro tidak error
- [ ] Comentor page tidak error
- [ ] Live session tidak error
- [ ] Semua halaman aman dari null pointer

### General
- [ ] Tidak ada query error di database
- [ ] Tidak ada PHP error/warning
- [ ] UI responsive dan menarik
- [ ] Button CTA redirect ke ruangai.id
- [ ] Performance tidak menurun

## Notes untuk Developer

1. **Selalu gunakan helper `is_scholarship_participant()` sebelum query beasiswa**
2. **Gunakan null coalescing operator (`??`) untuk default values**
3. **Include scholarship CTA component di halaman yang relevan**
4. **Test dengan kedua jenis user (beasiswa & kompetisi)**
5. **Pastikan tidak ada hardcoded assumption bahwa user pasti punya data beasiswa**

## URL dan Resources

- URL Pendaftaran Beasiswa: https://ruangai.id
- Helper Location: `app/Helpers/scholarship_helper.php`
- CTA Component: `app/Pages/_components/scholarship_cta.php`

---
**Created:** 2025-01-19
**Status:** ✅ Implemented
