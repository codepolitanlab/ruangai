<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRegionTables extends Migration
{
    protected $tableAttributes = [
        'ENGINE' => 'InnoDB',
        'DEFAULT CHARSET' => 'utf8',
        'COLLATE' => 'utf8_unicode_ci',
    ];

    public function up()
    {
        /**
         * Table: reg_provinces
         */
        $this->forge->addField([
            'id' => [
                'type'       => 'CHAR',
                'constraint' => 2,
                'null'       => false,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
        ]);
        $this->forge->addKey('id', true); // primary key
        $this->forge->createTable('reg_provinces', true, $this->tableAttributes);

        /**
         * Table: reg_regencies
         */
        $this->forge->addField([
            'id' => [
                'type'       => 'CHAR',
                'constraint' => 4,
                'null'       => false,
            ],
            'province_id' => [
                'type'       => 'CHAR',
                'constraint' => 2,
                'null'       => false,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
        ]);
        $this->forge->addKey('id', true); // primary key
        $this->forge->addKey('province_id'); // index regencies_province_id_index
        $this->forge->addForeignKey('province_id', 'reg_provinces', 'id', 'CASCADE', 'CASCADE', 'regencies_province_id_foreign');
        $this->forge->createTable('reg_regencies', true, $this->tableAttributes);

        /**
         * Table: reg_districts
         */
        $this->forge->addField([
            'id' => [
                'type'       => 'CHAR',
                'constraint' => 7,
                'null'       => false,
            ],
            'regency_id' => [
                'type'       => 'CHAR',
                'constraint' => 4,
                'null'       => false,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
        ]);
        $this->forge->addKey('id', true); // primary key
        $this->forge->addKey('regency_id'); // index districts_id_index
        $this->forge->addForeignKey('regency_id', 'reg_regencies', 'id', 'CASCADE', 'CASCADE', 'districts_regency_id_foreign');
        $this->forge->createTable('reg_districts', true, $this->tableAttributes);

        /**
         * Table: reg_villages
         */
        $this->forge->addField([
            'id' => [
                'type'       => 'CHAR',
                'constraint' => 10,
                'null'       => false,
            ],
            'district_id' => [
                'type'       => 'CHAR',
                'constraint' => 7,
                'null'       => false,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
        ]);
        $this->forge->addKey('id', true); // primary key
        $this->forge->addKey('district_id'); // index villages_district_id_index
        $this->forge->addForeignKey('district_id', 'reg_districts', 'id', 'CASCADE', 'CASCADE', 'villages_district_id_foreign');
        $this->forge->createTable('reg_villages', true, $this->tableAttributes);
    }

    public function down()
    {
        // Drop child tables first to avoid FK constraint errors
        if ($this->db->DBDriver === 'MySQLi') {
            // Ensure FK checks don't block drops in unusual states
            $this->db->query('SET FOREIGN_KEY_CHECKS=0;');
        }

        $this->forge->dropTable('reg_villages', true);
        $this->forge->dropTable('reg_districts', true);
        $this->forge->dropTable('reg_regencies', true);
        $this->forge->dropTable('reg_provinces', true);

        if ($this->db->DBDriver === 'MySQLi') {
            $this->db->query('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
