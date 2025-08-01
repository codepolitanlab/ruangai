<?php

namespace Course\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBunnyCollectionID extends Migration
{
    public function up()
    {
        $this->forge->addColumn('courses', [
            'bunny_collection_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 25,
                'null'       => true,
                'after'      => 'level',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('courses', 'bunny_collection_id');
    }
}
