<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreatePaymentTables extends Migration
{
    public function up()
    {
        // Tabel payments
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'checkout_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'client_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'customer_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'customer_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'customer_email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'customer_phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'customer_address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'amount_items' => [
                'type' => 'INT',
                'null' => true,
            ],
            'discount' => [
                'type'    => 'INT',
                'default' => 0,
                'null'    => true,
            ],
            'subtotal' => [
                'type' => 'INT',
                'null' => true,
            ],
            'payment_method' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'payment_fee' => [
                'type'    => 'INT',
                'default' => 0,
                'null'    => true,
            ],
            'shipping_fee' => [
                'type'    => 'INT',
                'default' => 0,
                'null'    => true,
            ],
            'tax' => [
                'type'    => 'INT',
                'default' => 0,
                'null'    => true,
            ],
            'total' => [
                'type' => 'INT',
                'null' => true,
            ],
            'meta' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
                'null'    => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('checkout_code');
        $this->forge->createTable('payments');

        // Tabel payment_items
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'payment_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'item_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'item_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'subtitle' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'price' => [
                'type' => 'INT',
                'null' => true,
            ],
            'normal_price' => [
                'type' => 'INT',
                'null' => true,
            ],
            'quantity' => [
                'type' => 'INT',
                'null' => true,
            ],
            'subtotal' => [
                'type' => 'INT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('payment_id');
        $this->forge->createTable('payment_items');

        // Tabel payment_webhook_logs
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'code' => [
                'type'       => 'VARCHAR',
                'constraint' => 24,
                'null'       => false,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
                'null'    => false,
            ],
            'payload' => [
                'type' => 'JSON',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('payment_webhook_logs');
    }

    public function down()
    {
        $this->forge->dropTable('payment_items');
        $this->forge->dropTable('payment_webhook_logs');
        $this->forge->dropTable('payments');
    }
}
