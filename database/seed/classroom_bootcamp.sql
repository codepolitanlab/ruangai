-- =====================================================================
-- SEED BOOTCAMP / CLASSROOM — 16 tabel cls_* (minimal, idempotent)
-- DB: app_ruangai_prod_06_26  (MySQL)
-- Referensi: PLAN.md §6  |  SPEC-BOOTCAMP.md  |  SPEC-BOOTCAMP-MEMBER.md
--
-- CATATAN SCHEMA:
--   * DB ini TIDAK punya tabel `mein_users`. Member & admin ada di `users`
--     (role_id: 1=Super, 2=Member, 3=Admin, 4=CO-Mentor).
--   * ADMIN_ID  = 1  (Aldiansyah Ibrahim, Super)  -> created_by / instructor / reviewed_by
--   * MEMBER_ID = 2  (Novan Junaedi, Member)       -> user_id peserta / pemilik karya
--
-- JALANKAN:
--   MYSQL_PWD='...' mysql -h localhost -u app app_ruangai_prod_06_26 < classroom_bootcamp.sql
-- =====================================================================

START TRANSACTION;

-- ---------------------------------------------------------------------
-- 0) BERSIHKAN DATA SEED ID TETAP (urut terbalik dari FK, idempotent)
-- ---------------------------------------------------------------------
DELETE FROM cls_member_works            WHERE id = 1;
DELETE FROM cls_feedbacks               WHERE id = 1;
DELETE FROM cls_class_feeds             WHERE id = 1;
DELETE FROM cls_notifications           WHERE id = 1;
DELETE FROM cls_submissions             WHERE id = 1;
DELETE FROM cls_learning_progress       WHERE id IN (1,2,3,4);
DELETE FROM cls_class_members           WHERE id = 1;
DELETE FROM cls_class_material_resources WHERE id = 1;
DELETE FROM cls_class_materials         WHERE id IN (1,2);
DELETE FROM cls_classes                 WHERE id = 1;
DELETE FROM cls_quiz_questions          WHERE id IN (1,2);
DELETE FROM cls_learning_resources      WHERE id IN (1,2,3,4,5,6);
DELETE FROM cls_materials               WHERE id IN (1,2);
DELETE FROM cls_syllabuses              WHERE id = 1;
DELETE FROM vouchers                    WHERE voucher_code = 'BC-BATCH1';

-- ---------------------------------------------------------------------
-- 1) MASTER KONTEN
-- ---------------------------------------------------------------------

-- 1.1 cls_syllabuses — 1 silabus published
INSERT INTO cls_syllabuses (id, name, subtitle, description, status, created_by)
VALUES (1, 'Bootcamp Vibe Coding', 'Dasar-dasar Pengembangan Web untuk Pemula',
        'Bootcamp intensif belajar HTML, CSS, dan JavaScript lewat praktik membangun proyek nyata.',
        'published', 1);

-- 1.2 cls_materials — 2 materi
INSERT INTO cls_materials (id, syllabus_id, title, subtitle, description, order_seq, weight, scoring_type)
VALUES
  (1, 1, 'Pengenalan & Setup Lingkungan', 'Minggu 1', 'Setup tools, struktur proyek, dan kontrak belajar.', 1, 0, 'auto'),
  (2, 1, 'Proyek Akhir: Landing Page', 'Minggu 2', 'Membangun landing page portofolio dari nol.', 2, 0, 'manual');

-- 1.3 cls_learning_resources — 6 resource (tipe utama)
INSERT INTO cls_learning_resources
(id, material_id, type, title, content, order_seq, completion_criteria, is_required, need_review)
VALUES
  -- Materi 1
  (1, 1, 'text', 'Selamat Datang di Bootcamp',
   '{"html":"<p>Selamat datang! Pelajari alur belajar dan aturan kelas pada halaman ini.</p>","instructions":"Baca sampai selesai lalu klik Saya Sudah Paham."}',
   1, 'view', 1, 0),
  (2, 1, 'video', 'Tutorial Setup Tools',
   '{"url":"https://www.youtube.com/watch?v=dQw4w9WgXcQ","platform":"youtube","duration":"00:12:30","instructions":"Tonton video lalu tandai selesai."}',
   2, 'view', 1, 0),
  (3, 1, 'meeting', 'Sesi Live: Kickoff',
   '{"description":"Perkenalan instruktur, roadmap materi, dan sesi tanya jawab.","duration":90,"mode":"offline_online","instructions":"Hadir sesuai jadwal; link menyusul via grup WA."}',
   3, 'view', 0, 0),
  -- Materi 2
  (4, 2, 'submission', 'Tugas: Submit Landing Page',
   '{"submission_type":"upload","instructions":"Upload file project (zip) atau link hasil deploy.","deadline_offset_days":7,"allowed_types":"pdf,zip,docx","max_size_mb":10}',
   1, 'submit', 1, 1),
  (5, 2, 'url', 'Referensi: Contoh Proyek',
   '{"url":"https://example.com/contoh-proyek","open_in":"tab","instructions":"Buka tautan sebagai referensi desain."}',
   2, 'view', 0, 0),
  (6, 2, 'quiz', 'Kuis Evaluasi Materi',
   '{"pass_score":70,"time_limit_minutes":10,"max_attempts":2,"instructions":"Jawab kuis untuk menguji pemahaman (opsional, menunggu fitur member)."}',
   3, 'score_pass', 1, 0);

-- 1.4 cls_quiz_questions — 2 soal (data kuis)
INSERT INTO cls_quiz_questions (id, resource_id, question, type, options, correct_answer, score, order_seq)
VALUES
  (1, 6, 'Apa kepanjangan dari HTML?', 'multiple_choice',
   '[{"label":"HyperText Markup Language","value":"a"},{"label":"HighText Machine Language","value":"b"},{"label":"HyperTool Markup Language","value":"c"}]',
   'a', 50, 1),
  (2, 6, 'Tag mana yang digunakan untuk judul utama?', 'multiple_choice',
   '[{"label":"<h1>","value":"a"},{"label":"<head>","value":"b"},{"label":"<p>","value":"c"}]',
   'a', 50, 2);

-- ---------------------------------------------------------------------
-- 2) KELAS & KEANGGOTAAN
-- ---------------------------------------------------------------------

-- 2.1 cls_classes — 1 kelas active (siap klaim sertifikat)
--     certificate_requirement = '4' -> resource submission id 4 wajib completed
INSERT INTO cls_classes
(id, syllabus_id, name, thumbnail, description, status, start_date, whatsapp_group_url,
 certificate_requirement, required_feedback_before_claim_certificate, certificate_claimable, created_by)
VALUES
  (1, 1, 'Bootcamp Vibe Coding — Batch 1',
   'https://picsum.photos/seed/bootcamp1/600/300',
   'Batch pertama bootcamp vibe coding. Peserta aktif terdaftar.',
   'active', '2026-09-01', 'https://chat.whatsapp.com/xxxxx',
   '4', 1, 1, 1);

-- 2.2 cls_class_materials — 2 jadwal materi (1 dibuka, 1 terkunci)
INSERT INTO cls_class_materials
(id, class_id, material_id, instructor_id, scheduled_at, is_open, opened_at, notes)
VALUES
  (1, 1, 1, 1, '2026-09-01 19:00:00', 1, '2026-09-01 19:00:00', 'Sesi pembukaan + setup.'),
  (2, 1, 2, 1, '2026-09-15 19:00:00', 0, NULL, 'Proyek akhir, dibuka setelah sesi 1 selesai.');

-- 2.3 cls_class_material_resources — metadata meeting materi 1 (opsional)
INSERT INTO cls_class_material_resources (id, class_id, material_id, resource_id, metadata)
VALUES (1, 1, 1, 3,
        '{"instructor_name":"Aldiansyah Ibrahim","zoom_link":"https://zoom.us/j/xxxxx","venue":"Online via Zoom","mode":"offline_online"}');

-- 2.4 cls_class_members — 1 member active
INSERT INTO cls_class_members (id, class_id, user_id, role, status)
VALUES (1, 1, 2, 'member', 'active');

-- ---------------------------------------------------------------------
-- 3) PROGRES & SUBMISSION
-- ---------------------------------------------------------------------

-- 3.1 cls_learning_progress — text & video completed, meeting not_started, tugas in_progress
INSERT INTO cls_learning_progress
(id, class_material_id, resource_id, user_id, status, completed_at)
VALUES
  (1, 1, 1, 2, 'completed', '2026-09-02 08:00:00'),
  (2, 1, 2, 2, 'completed', '2026-09-02 08:20:00'),
  (3, 1, 3, 2, 'not_started', NULL),
  (4, 2, 4, 2, 'in_progress', NULL);

-- 3.2 cls_submissions — 1 tugas status submitted (menunggu review)
INSERT INTO cls_submissions (id, progress_id, type, url, submitted_at, status)
VALUES (1, 4, 'url', 'https://github.com/member/landing-page', '2026-09-16 09:00:00', 'submitted');

-- ---------------------------------------------------------------------
-- 4) FEED, FEEDBACK, KARYA, NOTIFIKASI
-- ---------------------------------------------------------------------

-- 4.1 cls_class_feeds — 1 pengumuman pinned
INSERT INTO cls_class_feeds (id, class_id, title, body, pinned, created_by)
VALUES (1, 1, 'Selamat Datang Peserta Batch 1',
        'Silakan mulai dengan materi pertama dan kerjakan tugas di materi kedua. Selamat belajar!',
        1, 1);

-- 4.2 cls_feedbacks — 1 feedback member (syarat klaim sertifikat)
INSERT INTO cls_feedbacks
(id, class_id, user_id, profession, city, condition_before, reason_choice, favorite_moment,
 rating, concrete_skill, message_to_friend, allow_testimonial)
VALUES
  (1, 1, 2, 'Mahasiswa', 'Jakarta', 'a',
   'Ingin belajar web development dari nol.', 'Sesi live kickoff dan feedback instruktur',
   5, 'Mampu membuat landing page responsif', 'Wajib ikut, materinya praktikal!', 1);

-- 4.3 cls_member_works — 1 karya published
INSERT INTO cls_member_works
(id, user_id, title, thumbnail, photos, description, short_description, status, url_project)
VALUES
  (1, 2, 'Landing Page Portofolio',
   'https://picsum.photos/seed/work1/600/300',
   '["https://picsum.photos/seed/work1a/400/300","https://picsum.photos/seed/work1b/400/300"]',
   'Landing page portofolio pribadi hasil proyek akhir bootcamp. Dibangun dengan HTML & CSS murni.',
   'Landing page portofolio responsif', 'published',
   'https://github.com/member/landing-page');

-- 4.4 cls_notifications — opsional (tabel belum dikonsumsi kode)
INSERT INTO cls_notifications (id, user_id, type, title, body)
VALUES (1, 2, 'class_feed', 'Pengumuman Kelas', 'Selamat datang di Bootcamp Vibe Coding — Batch 1.');

COMMIT;

-- ---------------------------------------------------------------------
-- 5) VERIFIKASI
-- ---------------------------------------------------------------------
SELECT 'cls_syllabuses' t, COUNT(*) c FROM cls_syllabuses
UNION ALL SELECT 'cls_materials', COUNT(*) FROM cls_materials
UNION ALL SELECT 'cls_learning_resources', COUNT(*) FROM cls_learning_resources
UNION ALL SELECT 'cls_quiz_questions', COUNT(*) FROM cls_quiz_questions
UNION ALL SELECT 'cls_classes', COUNT(*) FROM cls_classes
UNION ALL SELECT 'cls_class_materials', COUNT(*) FROM cls_class_materials
UNION ALL SELECT 'cls_class_material_resources', COUNT(*) FROM cls_class_material_resources
UNION ALL SELECT 'cls_class_members', COUNT(*) FROM cls_class_members
UNION ALL SELECT 'cls_learning_progress', COUNT(*) FROM cls_learning_progress
UNION ALL SELECT 'cls_submissions', COUNT(*) FROM cls_submissions
UNION ALL SELECT 'cls_class_feeds', COUNT(*) FROM cls_class_feeds
UNION ALL SELECT 'cls_feedbacks', COUNT(*) FROM cls_feedbacks
UNION ALL SELECT 'cls_member_works', COUNT(*) FROM cls_member_works
UNION ALL SELECT 'cls_notifications', COUNT(*) FROM cls_notifications;
