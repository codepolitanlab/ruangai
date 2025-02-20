<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUserTable extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE `users`
        ADD `name` varchar(255) NULL AFTER `id`,
        ADD `phone` varchar(15) NULL AFTER `name`,
        ADD `email` varchar(255) NULL AFTER `phone`,
        ADD `avatar` varchar(255) NULL AFTER `email`,
        ADD `password` tinytext NULL AFTER `avatar`,
        ADD `token` varchar(150) NULL AFTER `password`,
        ADD `otp` varchar(6) NULL AFTER `token`,
        ADD `otp_email` varchar(6) NULL AFTER `otp`,
        ADD `otp_phone` varchar(6) NULL AFTER `otp_email`
        ;");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE `users`
        DROP `name`,
        DROP `phone`,
        DROP `email`,
        DROP `password`,
        DROP `token`,
        DROP `otp`,
        DROP `otp_email`,
        DROP `otp_phone`,
        DROP `avatar`;");
    }
}
