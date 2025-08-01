<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnGroupWhatsappCoursesToCourses extends Migration
{
    public function up()
    {
        $this->forge->addColumn('courses', [
            'group_whatsapp' => [
                'type'  => 'text',
                'null'  => true,
                'after' => 'thumbnail',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('courses', ['group_whatsapp']);
    }
}
