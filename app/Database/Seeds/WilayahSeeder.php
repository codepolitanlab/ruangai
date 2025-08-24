<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class WilayahSeeder extends Seeder
{
    /**
     * Konfigurasi
     * - $sqlPath: lokasi file SQL Anda
     * - $insertChunkSize: jumlah row per batch saat memecah INSERT besar
     */
    private string $sqlPath = APPPATH . 'Database/Seeds/wilayah_indonesia.sql';
    private int $insertChunkSize = 500; // sesuaikan sesuai kemampuan server

    public function run()
    {
        if (! is_file($this->sqlPath)) {
            throw new \RuntimeException('File SQL tidak ditemukan: ' . $this->sqlPath);
        }

        $db = $this->db; // BaseConnection

        // Matikan FK checks untuk percepat & hindari urutan dependensi
        $db->simpleQuery('SET FOREIGN_KEY_CHECKS=0');

        // Jika ingin transactional import (opsional):
        // Catatan: untuk file sangat besar, transaksi tunggal bisa memakan memory/redo log
        $useTransaction = false;
        if ($useTransaction) {
            $db->transException(true)->transStart();
        }

        $handle = fopen($this->sqlPath, 'rb');
        if ($handle === false) {
            throw new \RuntimeException('Gagal membuka file: ' . $this->sqlPath);
        }

        $buffer = '';
        $chunkSize = 1024 * 1024; // 1MB per read
        while (! feof($handle)) {
            $buffer .= fread($handle, $chunkSize);
            foreach ($this->extractStatements($buffer) as $statement) {
                $this->executeStatement($statement);
            }
        }
        // Eksekusi sisa statement bila ada
        $buffer = trim($buffer);
        if ($buffer !== '') {
            $this->executeStatement($buffer);
        }
        fclose($handle);

        if ($useTransaction) {
            $db->transComplete();
        }

        $db->simpleQuery('SET FOREIGN_KEY_CHECKS=1');

        echo "Import wilayah selesai.\n";
    }

    /**
     * Memecah buffer menjadi statement SQL berakhir ';' dengan menjaga string/quote.
     * Mengembalikan array statement lengkap. Sisa incomplete akan ditinggal di $buffer (by reference).
     */
    private function extractStatements(string &$buffer): array
    {
        $statements = [];
        $len = strlen($buffer);
        $start = 0;
        $inSingle = false; // '
        $inDouble = false; // "
        $inBacktick = false; // `
        for ($i = 0; $i < $len; $i++) {
            $ch = $buffer[$i];
            $prev = $i > 0 ? $buffer[$i - 1] : '';

            if ($ch === "'" && ! $inDouble && ! $inBacktick && $prev !== '\\') {
                $inSingle = ! $inSingle;
            } elseif ($ch === '"' && ! $inSingle && ! $inBacktick && $prev !== '\\') {
                $inDouble = ! $inDouble;
            } elseif ($ch === '`' && ! $inSingle && ! $inDouble) {
                $inBacktick = ! $inBacktick;
            }

            if (! $inSingle && ! $inDouble && ! $inBacktick && $ch === ';') {
                // statement lengkap
                $statements[] = trim(substr($buffer, $start, $i - $start));
                $start = $i + 1;
            }
        }

        // sisakan incomplete ke buffer
        $buffer = substr($buffer, $start);
        return array_filter($statements, fn($s) => $s !== '');
    }

    /**
     * Jalankan statement, dengan optimasi untuk INSERT besar (dipecah ke batch kecil).
     */
    private function executeStatement(string $statement): void
    {
        $trimmed = ltrim($statement);
        // Lewati komentar baris dan kosong
        if ($trimmed === '' || str_starts_with($trimmed, '--') || str_starts_with($trimmed, '#')) {
            return;
        }

        // Tangani multi-row INSERT: "INSERT INTO ... VALUES (...),(...),..."
        if (preg_match('/^INSERT\s+INTO\s+[^;]+\s+VALUES\s*\(/i', $trimmed)) {
            $this->executeChunkedInsert($trimmed);
            return;
        }

        // Statement biasa
        $this->db->simpleQuery($statement);
    }

    /**
     * Pecah multi-row INSERT menjadi batch $this->insertChunkSize.
     * Parser sederhana level tanda kurung untuk memisah tiap tuple VALUES(...).
     */
    private function executeChunkedInsert(string $insertSql): void
    {
        // Pisahkan header "INSERT INTO ... VALUES " dan daftar tuples
        if (! preg_match('/^(INSERT\s+INTO\s+.+?VALUES\s*)/is', $insertSql, $m)) {
            // fallback jika tak terdeteksi
            $this->db->simpleQuery($insertSql);
            return;
        }
        $prefix = rtrim($m[1]);
        $valuesPart = substr($insertSql, strlen($m[1]));

        // Ambil tuple satu per satu berdasarkan kurung
        $tuples = $this->splitTuples($valuesPart);
        $batch = [];
        foreach ($tuples as $tuple) {
            $batch[] = $tuple;
            if (count($batch) >= $this->insertChunkSize) {
                $sql = $prefix . ' ' . implode(',', $batch) . ';';
                $this->db->simpleQuery($sql);
                $batch = [];
            }
        }
        if (! empty($batch)) {
            $sql = $prefix . ' ' . implode(',', $batch) . ';';
            $this->db->simpleQuery($sql);
        }
    }

    /**
     * Memecah string VALUES menjadi array item "( ... )" dengan menghormati nested/quotes.
     */
    private function splitTuples(string $valuesPart): array
    {
        $tuples = [];
        $len = strlen($valuesPart);
        $depth = 0;
        $start = null;
        $inSingle = false;
        $inDouble = false;
        for ($i = 0; $i < $len; $i++) {
            $ch = $valuesPart[$i];
            $prev = $i > 0 ? $valuesPart[$i - 1] : '';

            if ($ch === "'" && ! $inDouble && $prev !== '\\') {
                $inSingle = ! $inSingle;
            } elseif ($ch === '"' && ! $inSingle && $prev !== '\\') {
                $inDouble = ! $inDouble;
            }

            if (! $inSingle && ! $inDouble) {
                if ($ch === '(') {
                    if ($depth === 0) {
                        $start = $i;
                    }
                    $depth++;
                } elseif ($ch === ')') {
                    $depth--;
                    if ($depth === 0 && $start !== null) {
                        $tuples[] = trim(substr($valuesPart, $start, $i - $start + 1));
                        $start = null;
                    }
                }
            }
        }

        return $tuples;
    }
}
