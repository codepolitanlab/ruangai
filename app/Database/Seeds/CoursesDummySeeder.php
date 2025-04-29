<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CoursesDummySeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Insert into courses
        $db->table('courses')->insert([
            'id' => 353,
            'partner_id' => 0,
            'revenue_sharing' => 0,
            'collaborators' => '',
            'course_title' => 'Ngonten Sakti dengan AI',
            'slug' => 'laravel-security',
            'cover' => 'https://madrasahdigital.id//uploads/madrasahdigital/sources/Cover%20Kelas%20Online%20Ngonten%20Sakti.png',
            'thumbnail' => 'https://madrasahdigital.id//uploads/madrasahdigital/sources/Cover%20Kelas%20Online%20Ngonten%20Sakti.png',
            'description' => '',
            'total_module' => 50,
            'total_time' => 32091,
            'total_student' => 0,
            'tags' => 'ngonten,ai,artificial intelligence,kecerdasan buatan',
            'premium' => 0,
            'status' => 'publish',
            'course_order' => 0,
            'last_update' => '0000-00-00 00:00:00',
            'level' => 'beginner',
            'created_at' => '2023-11-04 02:48:30',
            'updated_at' => '2023-12-01 13:07:45',
        ]);

        // Insert into course_meta
        $db->table('course_meta')->insert([
            'id' => 1,
            'seo_description' => '',
            'dependency' => '',
            'enable_quiz' => 0,
            'enable_checklist' => 1,
            'enable_finish' => 0,
            'enable_forum' => 0,
            'enable_telegram' => 0,
            'preview_video' => '',
            'preview_video_cover' => '',
            'video_screenshots' => '',
            'enable_dvd' => 0,
            'dvd_screenshots' => '',
            'sourcecode_url' => '',
            'case_study_desc' => '',
            'preview_url' => '',
            'project_screenshot' => '',
            'long_description' => '<p><span>Merupakan kelas online yang mempelajari tentang teknik-teknik rahasia kreasi konten digital dengan memanfaatkan kecanggihan AI...</span></p>',
            'created_at' => '2023-11-04 02:48:30',
        ]);

        // Insert into course_products
        $db->table('course_products')->insert([
            'id' => 1,
            'course_id' => 353,
            'title' => 'Lifetime',
            'duration' => 99999,
            'price' => 225000,
            'strike_price' => 500000,
            'created_at' => '2023-11-08 16:46:31',
            'updated_at' => '2025-04-29 12:26:15',
            'description' => '',
            'default_price' => 1,
        ]);

        // Insert into course_topics
        $db->table('course_topics')->insertBatch([
            ['id' => 1, 'course_id' => 353, 'topic_title' => 'Pengenalan', 'topic_slug' => 'Pengenalan', 'topic_order' => 1, 'free' => 0, 'status' => 1, 'created_at' => '2023-11-08 09:45:06'],
            ['id' => 2, 'course_id' => 353, 'topic_title' => '02 - AI dan Perkembangannya', 'topic_slug' => '02-AI-dan-Perkembangannya', 'topic_order' => 2, 'free' => 0, 'status' => 1, 'created_at' => '2023-11-29 07:32:54'],
            ['id' => 3, 'course_id' => 353, 'topic_title' => 'Mengenal ChatGPT', 'topic_slug' => 'Mengenal-ChatGPT', 'topic_order' => 3, 'free' => 0, 'status' => 1, 'created_at' => '2023-11-29 07:37:23'],
        ]);

        // Insert into course_lessons
        $db->table('course_lessons')->insertBatch([
            ['id' => 1, 'course_id' => 353, 'topic_id' => 1, 'quiz_id' => 0, 'status' => 1, 'lesson_title' => 'Selamat Datang', 'lesson_slug' => 'selamat-datang', 'type' => 'theory', 'video' => 'LPu_sxQWmpo', 'player' => 'youtube', 'thumbnail' => '', 'duration' => '03:29', 'lesson_order' => 1, 'current_revision' => 0, 'lesson_uri' => '', 'free' => 1, 'hash' => 'd4a6e60951884541301404ad73ac8b8d', 'checksum' => NULL, 'created_at' => '2023-11-08 09:45:40', 'updated_at' => NULL, 'deleted_at' => NULL],
            ['id' => 2, 'course_id' => 353, 'topic_id' => 1, 'quiz_id' => 0, 'status' => 1, 'lesson_title' => 'Kontrak Belajar', 'lesson_slug' => 'kontrak-belajar', 'type' => 'theory', 'video' => '2VSO6_beqMo', 'player' => 'youtube', 'thumbnail' => '', 'duration' => '02:27', 'lesson_order' => 2, 'current_revision' => 0, 'lesson_uri' => '', 'free' => 0, 'hash' => '56b96fd2d54705297829f84afc5ec22c', 'checksum' => NULL, 'created_at' => '2023-11-29 07:32:27', 'updated_at' => NULL, 'deleted_at' => NULL],
            ['id' => 3, 'course_id' => 353, 'topic_id' => 2, 'quiz_id' => 0, 'status' => 1, 'lesson_title' => 'Mengenal Artificial Intelligence', 'lesson_slug' => 'mengenal-artificial-intelligence', 'type' => 'theory', 'video' => 'mzwjOOrSsvc', 'player' => 'youtube', 'thumbnail' => '', 'duration' => '04:05', 'lesson_order' => 1, 'current_revision' => 0, 'lesson_uri' => '', 'free' => 0, 'hash' => 'd5a0d078646d44a06d809852c99ad9e3', 'checksum' => NULL, 'created_at' => '2023-11-29 07:34:06', 'updated_at' => NULL, 'deleted_at' => NULL],
            ['id' => 4, 'course_id' => 353, 'topic_id' => 2, 'quiz_id' => 0, 'status' => 1, 'lesson_title' => 'Sejarah Artificial Intelligence', 'lesson_slug' => 'sejarah-artificial-intelligence', 'type' => 'theory', 'video' => 'Dup5qaToOe8', 'player' => 'youtube', 'thumbnail' => '', 'duration' => '05:16', 'lesson_order' => 2, 'current_revision' => 0, 'lesson_uri' => '', 'free' => 0, 'hash' => '5302410e905b028672973573222b4e2a', 'checksum' => NULL, 'created_at' => '2023-11-29 07:34:47', 'updated_at' => NULL, 'deleted_at' => NULL],
            ['id' => 5, 'course_id' => 353, 'topic_id' => 2, 'quiz_id' => 0, 'status' => 1, 'lesson_title' => 'AI dalam Teknologi Saat Ini', 'lesson_slug' => 'ai-dalam-teknologi-saat-ini', 'type' => 'theory', 'video' => 'CcG78veLBbY', 'player' => 'youtube', 'thumbnail' => '', 'duration' => '08:13', 'lesson_order' => 3, 'current_revision' => 0, 'lesson_uri' => '', 'free' => 0, 'hash' => '263b68050d88425da019ac76ea8ccc49', 'checksum' => NULL, 'created_at' => '2023-11-29 07:35:21', 'updated_at' => NULL, 'deleted_at' => NULL],
            ['id' => 6, 'course_id' => 353, 'topic_id' => 2, 'quiz_id' => 0, 'status' => 1, 'lesson_title' => 'Potensi dan Tantangan AI', 'lesson_slug' => 'potensi-dan-tantangan-ai', 'type' => 'theory', 'video' => 'Loca-MszIrc', 'player' => 'youtube', 'thumbnail' => '', 'duration' => '09:26', 'lesson_order' => 4, 'current_revision' => 0, 'lesson_uri' => '', 'free' => 0, 'hash' => '4dadd72b13a79531548556f88dd59464', 'checksum' => NULL, 'created_at' => '2023-11-29 07:35:52', 'updated_at' => NULL, 'deleted_at' => NULL],
            ['id' => 7, 'course_id' => 353, 'topic_id' => 2, 'quiz_id' => 0, 'status' => 1, 'lesson_title' => 'Prinsip Kreasi Konten dengan AI', 'lesson_slug' => 'prinsip-kreasi-konten-dengan-ai', 'type' => 'theory', 'video' => 'dXedhK3qquA', 'player' => 'youtube', 'thumbnail' => '', 'duration' => '6:57', 'lesson_order' => 5, 'current_revision' => 0, 'lesson_uri' => '', 'free' => 0, 'hash' => 'd97d52f5feb742c804333d7710a88f1d', 'checksum' => NULL, 'created_at' => '2023-11-29 07:36:24', 'updated_at' => NULL, 'deleted_at' => NULL],
            ['id' => 8, 'course_id' => 353, 'topic_id' => 2, 'quiz_id' => 0, 'status' => 1, 'lesson_title' => 'ChatGPT dan Midjourney', 'lesson_slug' => 'chatgpt-dan-midjourney', 'type' => 'theory', 'video' => 'KSwaKOuWdo0', 'player' => 'youtube', 'thumbnail' => '', 'duration' => '01:35', 'lesson_order' => 6, 'current_revision' => 0, 'lesson_uri' => '', 'free' => 0, 'hash' => 'a1daf76478310d17fd0883d2d11e66e4', 'checksum' => NULL, 'created_at' => '2023-11-29 07:37:03', 'updated_at' => NULL, 'deleted_at' => NULL],
            ['id' => 9, 'course_id' => 353, 'topic_id' => 3, 'quiz_id' => 0, 'status' => 1, 'lesson_title' => 'Berkenalan dengan ChatGPT', 'lesson_slug' => 'berkenalan-dengan-chatgpt', 'type' => 'theory', 'video' => 'aQny9Jt3iqI', 'player' => 'youtube', 'thumbnail' => '', 'duration' => '02:51', 'lesson_order' => 1, 'current_revision' => 0, 'lesson_uri' => '', 'free' => 0, 'hash' => 'd69fa52f2ebf07e23d9e862bbd58a1f2', 'checksum' => NULL, 'created_at' => '2023-11-29 07:37:55', 'updated_at' => NULL, 'deleted_at' => NULL],
            ['id' => 10, 'course_id' => 353, 'topic_id' => 3, 'quiz_id' => 0, 'status' => 1, 'lesson_title' => 'Cara Kerja ChatGPT', 'lesson_slug' => 'cara-kerja-chatgpt', 'type' => 'theory', 'video' => 'suiR67E10Qc', 'player' => 'youtube', 'thumbnail' => '', 'duration' => '03:16', 'lesson_order' => 2, 'current_revision' => 0, 'lesson_uri' => '', 'free' => 0, 'hash' => '80712f84dcc4cb2610effb013b441615', 'checksum' => NULL, 'created_at' => '2023-11-29 07:38:38', 'updated_at' => NULL, 'deleted_at' => NULL],
        ]);

        // Insert into course_lesson_theory
        $db->table('course_lesson_theory')->insertBatch([
            ['id' => 1, 'lesson_id' => 1, 'theory' => '', 'revision' => 0, 'status' => 'publish'],
            ['id' => 2, 'lesson_id' => 2, 'theory' => '', 'revision' => 0, 'status' => 'publish'],
            ['id' => 3, 'lesson_id' => 3, 'theory' => '', 'revision' => 0, 'status' => 'publish'],
            ['id' => 4, 'lesson_id' => 4, 'theory' => '', 'revision' => 0, 'status' => 'publish'],
            ['id' => 5, 'lesson_id' => 5, 'theory' => '', 'revision' => 0, 'status' => 'publish'],
            ['id' => 6, 'lesson_id' => 6, 'theory' => '', 'revision' => 0, 'status' => 'publish'],
            ['id' => 7, 'lesson_id' => 7, 'theory' => '', 'revision' => 0, 'status' => 'publish'],
            ['id' => 8, 'lesson_id' => 8, 'theory' => '', 'revision' => 0, 'status' => 'publish'],
            ['id' => 9, 'lesson_id' => 9, 'theory' => '', 'revision' => 0, 'status' => 'publish'],
            ['id' => 10, 'lesson_id' => 10, 'theory' => '', 'revision' => 0, 'status' => 'publish'],
        ]);

        // Insert into course_lesson_progress
        $db->table('course_lesson_progress')->insertBatch([
            ['id' => 1, 'course_id' => 353, 'lesson_id' => 1, 'user_id' => 1, 'created_at' => '2023-12-05 03:55:34'],
            ['id' => 2, 'course_id' => 353, 'lesson_id' => 2, 'user_id' => 1, 'created_at' => '2023-12-05 04:10:01'],
        ]);
    }
}
