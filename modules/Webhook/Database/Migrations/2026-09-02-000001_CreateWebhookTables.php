<?php

namespace Webhook\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Membuat tabel webhook_sources & webhook_logs untuk modul Webhook.
 *
 * Jalankan: php spark migrate -n 'Webhook'
 */
class CreateWebhookTables extends Migration
{
    public function up()
    {
        // ------------------------------------------------------------------
        // webhook_sources — daftar sumber/provider webhook + secret key
        // ------------------------------------------------------------------
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => false,
            ],
            'secret' => [
                'type'       => 'VARCHAR',
                'constraint' => 191,
                'null'       => false,
            ],
            'header_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => 'X-Callback-Token',
                'null'       => false,
            ],
            'handler' => [
                'type'       => 'VARCHAR',
                'constraint' => 191,
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default'    => 'active',
                'null'       => false,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('webhook_sources');

        // ------------------------------------------------------------------
        // webhook_logs — riwayat setiap webhook yang masuk
        // ------------------------------------------------------------------
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'source_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],
            'source_slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'event' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'method' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'headers' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'payload' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'ip_address' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'success', 'failed'],
                'default'    => 'pending',
                'null'       => false,
            ],
            'error_message' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'response_status' => [
                'type' => 'SMALLINT',
                'null' => true,
            ],
            'processed_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'is_reviewed' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'null'       => false,
            ],
            'reviewed_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'reviewed_by' => [
                'type' => 'INT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('source_id');
        $this->forge->addKey('source_slug');
        $this->forge->addKey('status');
        $this->forge->addKey('is_reviewed');
        $this->forge->addKey('created_at');
        $this->forge->createTable('webhook_logs');
    }

    public function down()
    {
        $this->forge->dropTable('webhook_logs', true);
        $this->forge->dropTable('webhook_sources', true);
    }
}
