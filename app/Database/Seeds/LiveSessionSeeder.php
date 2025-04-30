<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LiveSessionSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        $db->table('live_sessions')->insertBatch([
            [
                'id' => 1,
                'course_id' => 0,
                'title' => 'Live Session 1',
                'description' => 'Live Session course RuangAI',
                'thumbnail' => 'https://fahum.umsu.ac.id/blog/wp-content/uploads/2025/01/apa-itu-ai-berikut-pengertian-kelebihan-kekurangan-dan-penerapannya-dalam-kehidupan.jpg',
                'total_students' => 1,
                'is_required' => 1,
                'created_at' => '2025-04-22 07:31:26',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ],
            [
                'id' => 2,
                'course_id' => 0,
                'title' => 'Live Session 2',
                'description' => 'Teknik Prompting',
                'thumbnail' => 'https://fahum.umsu.ac.id/blog/wp-content/uploads/2025/01/apa-itu-ai-berikut-pengertian-kelebihan-kekurangan-dan-penerapannya-dalam-kehidupan.jpg',
                'total_students' => 2,
                'is_required' => 1,
                'created_at' => '2025-04-22 08:02:25',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ],
            [
                'id' => 3,
                'course_id' => 0,
                'title' => 'Live Session 3',
                'description' => 'Menggunakan AI Secara Bijak',
                'thumbnail' => 'https://fahum.umsu.ac.id/blog/wp-content/uploads/2025/01/apa-itu-ai-berikut-pengertian-kelebihan-kekurangan-dan-penerapannya-dalam-kehidupan.jpg',
                'total_students' => 2,
                'is_required' => 1,
                'created_at' => '2025-04-22 08:02:25',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ],
        ]);
    }
}
