<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnPrevChapterOnParticipants extends Migration
{
    public function up()
    {
        $this->forge->addColumn('scholarship_participants', [
            'prev_chapter' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => null,
                'null'       => true,
                'after'      => 'program',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('scholarship_participants', ['prev_chapter']);
    }
}
