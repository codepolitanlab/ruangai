<?php

namespace Heroicadmin\Modules\Dashboard\Controllers;

use Heroicadmin\Controllers\AdminController;

class Dashboard extends AdminController
{
    public function index()
    {
        $this->data['page_title'] = 'Dashboard';

        return view('Heroicadmin\Modules\Dashboard\Views\index', $this->data);
    }

    public function alibabaCsvImport()
    {
        $this->data['page_title'] = 'Import Alibaba Cloud ID';

        return view('Heroicadmin\Modules\Dashboard\Views\alibaba_import', $this->data);
    }

    public function alibabaCsvImportProcess()
    {
        $file = $this->request->getFile('csv_file');

        if (! $file || ! $file->isValid() || $file->getClientExtension() !== 'csv') {
            return redirect()->back()->with('error_message', 'File CSV tidak valid.');
        }

        $db      = \Config\Database::connect();
        $rows    = array_map('str_getcsv', file($file->getTempName()));
        $headers = array_map('trim', array_shift($rows));

        $emailCol         = array_search('email', $headers);
        $alibabaCol       = array_search('alibaba_cloud_id', $headers);

        if ($emailCol === false || $alibabaCol === false) {
            return redirect()->back()->with('error_message', 'Header CSV harus mengandung kolom: email, alibaba_cloud_id');
        }

        $updated  = 0;
        $notFound = [];

        foreach ($rows as $row) {
            if (count($row) < 2) continue;

            $email          = trim($row[$emailCol]);
            $alibabaCloudId = trim($row[$alibabaCol]);

            if (empty($email) || empty($alibabaCloudId)) continue;

            $user = $db->table('users')
                ->select('id')
                ->where('email', $email)
                ->get()
                ->getRowArray();

            if (! $user) {
                $notFound[] = $email;
                continue;
            }

            $db->table('user_profiles')
                ->where('user_id', $user['id'])
                ->update(['alibaba_cloud_id' => $alibabaCloudId]);

            $updated++;
        }

        $message = "Berhasil update {$updated} data.";
        if ($notFound) {
            $message .= ' Email tidak ditemukan: ' . implode(', ', $notFound);
        }

        return redirect()->back()->with('success_message', $message);
    }
}
