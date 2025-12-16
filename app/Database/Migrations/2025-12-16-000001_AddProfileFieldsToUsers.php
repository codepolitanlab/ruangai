<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProfileFieldsToUsers extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        $fields = $db->getFieldNames('users');

        $forge = \Config\Database::forge();

        $add = [];
        if (!in_array('whatsapp', $fields)) {
            $add['whatsapp'] = ['type' => 'VARCHAR', 'constraint' => 32, 'null' => true];
        }
        if (!in_array('address', $fields)) {
            $add['address'] = ['type' => 'TEXT', 'null' => true];
        }
        if (!in_array('gender', $fields)) {
            $add['gender'] = ['type' => 'VARCHAR', 'constraint' => 16, 'null' => true];
        }
        if (!in_array('alibabacloud_id', $fields)) {
            $add['alibabacloud_id'] = ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true];
        }
        if (!in_array('alibabacloud_screenshot', $fields)) {
            $add['alibabacloud_screenshot'] = ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true];
        }
        if (!in_array('profession', $fields)) {
            $add['profession'] = ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true];
        }
        if (!in_array('job_title', $fields)) {
            $add['job_title'] = ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true];
        }
        if (!in_array('company', $fields)) {
            $add['company'] = ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true];
        }
        if (!in_array('industry', $fields)) {
            $add['industry'] = ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true];
        }
        if (!in_array('referral_code', $fields)) {
            $add['referral_code'] = ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true];
        }
        if (!in_array('agreed_terms', $fields)) {
            $add['agreed_terms'] = ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0];
        }

        if (!empty($add)) {
            $forge->addColumn('users', $add);
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();
        $fields = $db->getFieldNames('users');

        $drop = [];
        $possible = ['whatsapp','address','gender','alibabacloud_id','alibabacloud_screenshot','profession','job_title','company','industry','referral_code','agreed_terms'];
        foreach ($possible as $col) {
            if (in_array($col, $fields)) {
                $drop[] = $col;
            }
        }

        if (!empty($drop)) {
            $forge = \Config\Database::forge();
            $forge->dropColumn('users', $drop);
        }
    }
}
