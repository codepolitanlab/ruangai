<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnsToUserProfile extends Migration
{
    public function up()
    {
        $this->forge->addColumn('user_profiles', [
            'birthday' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'identity_card_image',
            ],
            'gender' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
                'default' => 'male',
                'after' => 'birthday',
            ],
            'province' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'gender',
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'province',
            ],
            'occupation' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'city',
            ],
            'work_experience' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'occupation',
            ],
            'skill' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'work_experience',
            ],
            'institution' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'skill',
            ],
            'major' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'institution',
            ],
            'semester' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'default' => 0,
                'after' => 'major',
            ],
            'grade' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'default' => 0,
                'after' => 'semester',
            ],
            'type_of_business' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'grade',
            ],
            'business_duration' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'type_of_business',
            ],
            'education_level' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'business_duration',
            ],
            'graduation_year' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'education_level',
            ],
            'link_business' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'graduation_year',
            ],
            'last_project' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'link_business',
            ],
            'x_profile_url' => [
                'type' => 'VARCHAR',
                'constraint' => 355,
                'null' => true,
                'after' => 'last_project',
            ],
            'alibaba_cloud_id' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'x_profile_url',
            ],
            'alibaba_cloud_screenshot' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'alibaba_cloud_id',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('user_profiles', [
            'birthday',
            'gender',
            'province',
            'city',
            'occupation',
            'work_experience',
            'skill',
            'institution',
            'major',
            'semester',
            'grade',
            'type_of_business',
            'business_duration',
            'education_level',
            'graduation_year',
            'link_business',
            'last_project',
        ]);
    }
}
