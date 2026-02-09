<?php

namespace Challenge\Controllers;

use Heroicadmin\Controllers\AdminController;
use Challenge\Models\ChallengeAlibabaModel;

class Submissions extends AdminController
{
    protected $model;
    protected $helpers = ['form', 'challenge'];

    public function __construct()
    {
        $this->data['page_title'] = 'Challenge Submissions';
        $this->data['module']     = 'challenge';
        $this->data['submodule']  = 'submissions';

        $this->model = new ChallengeAlibabaModel();
    }

    /**
     * List all submissions with DataTables
     */
    public function index()
    {
        // Handle AJAX request for DataTables
        if ($this->request->isAJAX()) {
            return $this->datatables();
        }

        return view('Challenge\Views\submissions\index', $this->data);
    }

    /**
     * DataTables AJAX handler
     */
    private function datatables()
    {
        $request = $this->request;
        
        $draw   = (int) $request->getPost('draw');
        $start  = (int) ($request->getPost('start') ?? 0);
        $length = (int) ($request->getPost('length') ?? 10);
        $search = $request->getPost('search')['value'] ?? '';
        $status = $request->getPost('status') ?? '';

        $builder = $this->model->select('challenge_alibaba.*, users.name as user_name, users.email as user_email')
            ->join('users', 'users.id = challenge_alibaba.user_id', 'left');

        // Filter by status
        if (!empty($status)) {
            $builder->where('challenge_alibaba.status', $status);
        }

        // Search
        if (!empty($search)) {
            $builder->groupStart()
                ->like('users.name', $search)
                ->orLike('users.email', $search)
                ->orLike('challenge_alibaba.video_title', $search)
                ->orLike('challenge_alibaba.twitter_post_url', $search)
                ->groupEnd();
        }

        $totalRecords = $this->model->countAllResults(false);
        $recordsFiltered = $builder->countAllResults(false);

        $data = $builder->orderBy('challenge_alibaba.created_at', 'DESC')
            ->limit($length, $start)
            ->get()
            ->getResultArray();

        $result = [];
        foreach ($data as $row) {
            $result[] = [
                'id' => $row['id'],
                'user_name' => $row['user_name'],
                'user_email' => $row['user_email'],
                'video_title' => $row['video_title'],
                'status' => $row['status'],
                'submitted_at' => $row['submitted_at'] ? date('d M Y H:i', strtotime($row['submitted_at'])) : '-',
                'actions' => '<a href="' . site_url('ruangpanel/challenge/submissions/detail/' . $row['id']) . '" class="btn btn-sm btn-info">Detail</a>',
            ];
        }

        return $this->response->setJSON([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $recordsFiltered,
            'data' => $result,
        ]);
    }

    /**
     * View submission detail
     */
    public function detail($id)
    {
        $submission = $this->model->getWithUserInfo($id);

        if (!$submission) {
            return redirect()->to('/challenge/submissions')->with('error', 'Submission tidak ditemukan');
        }

        // Parse team members
        $submission['team_members_array'] = [];
        if (!empty($submission['team_members'])) {
            $submission['team_members_array'] = json_decode($submission['team_members'], true) ?? [];
        }

        $this->data['submission'] = $submission;

        return view('Challenge\Views\submissions\detail', $this->data);
    }

    /**
     * Approve submission
     */
    public function approve($id)
    {
        $notes = $this->request->getPost('notes');

        if ($this->model->updateStatus($id, 'approved', $notes)) {
            return redirect()->to('/challenge/submissions/detail/' . $id)
                ->with('success', 'Submission berhasil disetujui');
        }

        return redirect()->back()->with('error', 'Gagal menyetujui submission');
    }

    /**
     * Reject submission
     */
    public function reject($id)
    {
        $notes = $this->request->getPost('notes');

        if (empty($notes)) {
            return redirect()->back()->with('error', 'Alasan penolakan harus diisi');
        }

        if ($this->model->updateStatus($id, 'rejected', $notes)) {
            $submission = $this->model->getWithUserInfo($id);
            if (!empty($submission['user_email'])) {
                $name = $submission['user_name'] ?? 'Peserta';
                $reason = $notes ?: 'Tidak ada catatan tambahan.';
                $message = '<p>Halo ' . esc($name) . ',</p>'
                    . '<p>Terima kasih sudah mengikuti GenAI Video Fest. Mohon maaf, submission Anda belum dapat kami terima.</p>'
                    . '<p><strong>Alasan penolakan:</strong><br>' . nl2br(esc($reason)) . '</p>'
                    . '<p>Anda masih bisa melihat detail submission di dashboard kompetisi.</p>'
                    . '<p><a href="' . site_url('challenge/submit') . '">Buka Dashboard Kompetisi</a></p>'
                    . '<p>Salam,<br>Tim GenAI Video Fest</p>';

                $Heroic = new \App\Libraries\Heroic();
                $Heroic->sendEmail($submission['user_email'], 'Submission Anda Ditolak - GenAI Video Fest', $message);
            }
            return redirect()->to('/challenge/submissions/detail/' . $id)
                ->with('success', 'Submission berhasil ditolak');
        }

        return redirect()->back()->with('error', 'Gagal menolak submission');
    }

    /**
     * Validate submission (Tahap 0 - Admin validation)
     */
    public function validateSubmission($id)
    {
        $notes = $this->request->getPost('notes');

        if ($this->model->updateStatus($id, 'review', $notes)) {
            return redirect()->to('/challenge/submissions/detail/' . $id)
                ->with('success', 'Submission berhasil divalidasi');
        }

        return redirect()->back()->with('error', 'Gagal validasi submission');
    }

    /**
     * Bulk approve submissions
     */
    public function bulkApprove()
    {
        $ids = $this->request->getPost('ids');

        if (empty($ids) || !is_array($ids)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tidak ada submission yang dipilih',
            ]);
        }

        $success = 0;
        foreach ($ids as $id) {
            if ($this->model->updateStatus($id, 'approved')) {
                $success++;
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => "{$success} submission berhasil disetujui",
        ]);
    }

    /**
     * Download file
     */
    public function download($id, $fileType)
    {
        $submission = $this->model->find($id);

        if (!$submission) {
            return redirect()->back()->with('error', 'Submission tidak ditemukan');
        }

        $allowedTypes = ['prompt_file', 'params_file', 'assets_list_file', 'alibaba_screenshot', 'twitter_follow_screenshot'];

        if (!in_array($fileType, $allowedTypes) || empty($submission[$fileType])) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        $filePath = WRITEPATH . 'uploads/challenge/' . $submission['user_id'] . '/' . $submission[$fileType];

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan di server');
        }

        return $this->response->download($filePath, null);
    }

    /**
     * Delete submission (soft delete)
     */
    public function delete($id)
    {
        if ($this->model->delete($id)) {
            return redirect()->to('/challenge/submissions')
                ->with('success', 'Submission berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Gagal menghapus submission');
    }

    /**
     * Export submissions to CSV
     */
    public function export()
    {
        $submissions = $this->model->select('challenge_alibaba.*, users.name as user_name, users.email as user_email, users.phone as user_phone')
            ->join('users', 'users.id = challenge_alibaba.user_id', 'left')
            ->findAll();

        $csv = "ID,User Name,Email,Phone,Video Title,Twitter URL,Status,Team Members,Submitted At\n";

        foreach ($submissions as $row) {
            $teamMembers = '';
            if (!empty($row['team_members'])) {
                $members = json_decode($row['team_members'], true);
                $teamMembers = implode('; ', array_map(function($m) {
                    return $m['name'] . ' (' . $m['email'] . ')';
                }, $members));
            }

            $csv .= sprintf(
                '"%s","%s","%s","%s","%s","%s","%s","%s","%s"' . "\n",
                $row['id'],
                $row['user_name'],
                $row['user_email'],
                $row['user_phone'],
                $row['video_title'],
                $row['twitter_post_url'],
                $row['status'],
                $teamMembers,
                $row['submitted_at'] ?? '-'
            );
        }

        return $this->response
            ->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="challenge_submissions_' . date('Y-m-d') . '.csv"')
            ->setBody($csv);
    }
}
