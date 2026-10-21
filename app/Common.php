<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

if (! function_exists('class_batch_label')) {
    /**
     * Label batch untuk kartu kelas:
     * 1) akhiran nama kelas setelah pemisah " — / – / - ", mis. "Bootcamp Vibe Coding — Batch 1"
     * 2) nama silabus bila memang berbentuk label batch, mis. "Batch 2"
     * null bila tidak ada — badge batch disembunyikan.
     */
    function class_batch_label(?string $className, ?string $syllabusName = null): ?string
    {
        if ($className !== null && preg_match('/\s+[—–-]\s*(.+)$/u', $className, $m) && trim($m[1]) !== '') {
            return trim($m[1]);
        }

        if ($syllabusName !== null && preg_match('/\bbatch\b/i', $syllabusName)) {
            return trim($syllabusName);
        }

        return null;
    }
}
