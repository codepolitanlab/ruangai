<?php

namespace Classroom\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

/**
 * Menambahkan kolom created_at / updated_at / deleted_at yang hilang pada
 * tabel cls_* agar SEMUA tabel konsisten memiliki ketiganya.
 *
 * Migration create awal sudah diterapkan, dan struktur DB aktual bisa berbeda
 * antar environment (sebagian kolom mungkin sudah ada / ditambah manual),
 * sehingga migration ini bersifat DEFENSIF: tiap kolom hanya ditambahkan bila
 * belum ada di tabel (dicek via information_schema). down() hanya menghapus
 * kolom yang benar-benar ditambahkan oleh migration ini pada proses yang sama,
 * sehingga kolom yang sudah ada sebelumnya TIDAK ikut terhapus saat rollback.
 */
class AddTimestampColumnsToClsTables extends Migration
{
    /**
     * Kolom yang benar-benar ditambahkan oleh migration ini: [table => [cols]].
     * Dipakai oleh down() agar tidak menghapus kolom yang sudah ada sebelumnya.
     *
     * @var array<string, string[]>
     */
    private array $added = [];

    public function up()
    {
        $createdAt = ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')];
        $updatedAt = ['type' => 'TIMESTAMP', 'null' => true];
        $deletedAt = ['type' => 'TIMESTAMP', 'null' => true];

        // Rencana penambahan: tabel yang perlu dilengkapi beserta kolomnya.
        // Defensif: kolom yang sudah ada di-skip (perbedaan struktur antar env).
        $plan = [
            // deleted_at sudah didefinisikan migration create; hanya timestamps yang kurang
            'cls_materials'                => ['created_at' => $createdAt, 'updated_at' => $updatedAt],
            'cls_learning_resources'       => ['created_at' => $createdAt, 'updated_at' => $updatedAt],
            'cls_quiz_questions'           => ['created_at' => $createdAt, 'updated_at' => $updatedAt, 'deleted_at' => $deletedAt],
            'cls_class_materials'          => ['deleted_at' => $deletedAt],
            'cls_class_material_resources' => ['deleted_at' => $deletedAt],
            'cls_class_members'            => ['created_at' => $createdAt, 'updated_at' => $updatedAt, 'deleted_at' => $deletedAt],
            'cls_quiz_results'             => ['created_at' => $createdAt, 'updated_at' => $updatedAt, 'deleted_at' => $deletedAt],
            'cls_submissions'              => ['created_at' => $createdAt, 'updated_at' => $updatedAt, 'deleted_at' => $deletedAt],
            'cls_member_scores'            => ['created_at' => $createdAt, 'updated_at' => $updatedAt, 'deleted_at' => $deletedAt],
            'cls_class_feeds'              => ['deleted_at' => $deletedAt],
            'cls_notifications'            => ['updated_at' => $updatedAt, 'deleted_at' => $deletedAt],
        ];

        foreach ($plan as $table => $columns) {
            foreach ($columns as $column => $definition) {
                if ($this->columnMissing($table, $column)) {
                    $this->forge->addColumn($table, [$column => $definition]);
                    $this->added[$table][] = $column;
                }
            }
        }

        // Backfill created_at (hanya jika kolom baru saja ditambahkan oleh
        // migration ini) dari kolom waktu alami agar data lama tetap akurat.
        $backfills = [
            'cls_class_members' => 'enrolled_at',
            'cls_quiz_results'  => 'submitted_at',
            'cls_submissions'   => 'submitted_at',
            'cls_member_scores' => 'scored_at',
        ];

        foreach ($backfills as $table => $sourceColumn) {
            if (in_array('created_at', $this->added[$table] ?? [], true)) {
                $this->backfillCreatedAt($table, $sourceColumn);
            }
        }
    }

    /**
     * Cek apakah sebuah kolom belum ada di tabel (defensif, agar migration ini
     * aman dijalankan di DB mana pun tanpa error "Duplicate column").
     */
    private function columnMissing(string $table, string $column): bool
    {
        $row = $this->db->query(
            'SELECT COUNT(*) AS total FROM information_schema.COLUMNS
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = ?
               AND COLUMN_NAME = ?',
            [$table, $column]
        )->getRow();

        return (int) $row->total === 0;
    }

    /**
     * @param string $table        Nama tabel
     * @param string $sourceColumn Kolom waktu alami sumber backfill created_at
     */
    private function backfillCreatedAt(string $table, string $sourceColumn): void
    {
        $this->db->query(
            "UPDATE {$table} SET created_at = {$sourceColumn} WHERE {$sourceColumn} IS NOT NULL"
        );
    }

    public function down()
    {
        foreach ($this->added as $table => $columns) {
            $this->forge->dropColumn($table, implode(',', $columns));
        }
    }
}
