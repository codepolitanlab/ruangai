<?php

namespace Referral\Controllers;

use Heroicadmin\Controllers\AdminController;
use Referral\Models\ReferralWithdrawalModel;

class Withdrawal extends AdminController
{
    protected $withdrawalModel;

    public function __construct()
    {
        $this->data['page_title'] = 'Referral Withdrawals';
        $this->data['module']     = 'referral';
        $this->data['submodule']  = 'withdrawals';

        $this->withdrawalModel = new ReferralWithdrawalModel();
    }

    public function index()
    {   
        $this->data = array_merge($this->data, []);

        return view('Referral\Views\withdrawals\table', $this->data);
    }

    public function table()
    {
        $filters = $this->request->getGet('filter') ?? [];
        $visible = $this->request->getGet('visible') ?? [];
        $page    = max(1, (int) $this->request->getGet('page'));
        $perPage = $this->request->getGet('perpage') ?? 10;

        $builder = $this->withdrawalModel->getFiltered($filters);

        $select = [];
        $select[] = 'referral_withdrawal.id';
        if (!empty($visible['user'])) {
            $select[] = 'users.name as user_name';
            $select[] = 'users.email as user_email';
        }
        if (!empty($visible['amount'])) {
            $select[] = 'referral_withdrawal.amount';
        }
        if (!empty($visible['created_at'])) {
            $select[] = 'referral_withdrawal.created_at';
        }
        if (!empty($visible['withdrawn_at'])) {
            $select[] = 'referral_withdrawal.withdrawn_at';
        }
        if (!empty($visible['description'])) {
            $select[] = 'referral_withdrawal.description';
        }

        $builder->select(implode(',', $select));

        $total = $builder->countAllResults(false);

        $builder->limit($perPage, ($page - 1) * $perPage);

        $data['withdrawals'] = $builder->get()->getResultArray();
        $data['currentPage'] = $page;
        $data['totalPages']  = ceil($total / $perPage);
        $data['visible']     = $visible;

        return view('Referral\Views\withdrawals\_table_body', $data);
    }

    public function form($id = null)
    {
        $withdrawal = null;

        if ($id) {
            $withdrawal = $this->withdrawalModel->find($id);
            if (!$withdrawal) {
                return redirect()->to(admin_url() . 'referral/withdrawals')
                    ->with('error_message', 'Withdrawal not found');
            }
        }

        // No large user list; better to use Ajax selection in form
        $initialUser = null;
        if ($withdrawal && !empty($withdrawal['user_id'])) {
            $referralModel = new \Referral\Models\ReferralModel();
            $user = $referralModel->where('user_id', $withdrawal['user_id'])->first();
            $initialUser = [
                'id' => $user['id'], 
                'name' => $user['fullname'], 
                'email' => $user['email'],
                'balance' => $user['balance'] ?? 0
            ];
        }
        $data = [
            'page_title' => $id ? 'Edit Withdrawal' : 'Create Withdrawal',
            'withdrawal' => $withdrawal,
            'initialUser' => $initialUser,
        ];

        $this->data = array_merge($this->data, $data);
        return view('Referral\Views\withdrawals\form', $this->data);
    }

    public function save($id = null)
    {
        $rules = [
            'user_id' => 'required|integer',
            'amount' => 'required|decimal',
            'withdrawn_at' => 'permit_empty'
        ];
        $rules['description'] = 'permit_empty|string|max_length[1000]';

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $postData = $this->request->getPost();

        $data = [
            'user_id' => $postData['user_id'],
            'amount' => $postData['amount'],
            'description' => $postData['description'] ?? null,
        ];

        // Handle withdrawn_at from input datetime-local (e.g., 2025-11-27T14:30)
        if (!empty($postData['withdrawn_at'])) {
            // Replace T with space and append seconds if needed
            $wt = str_replace('T', ' ', $postData['withdrawn_at']);
            // Ensure seconds
            if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/', $wt)) {
                $wt .= ':00';
            }
            $data['withdrawn_at'] = $wt;
        } else {
            $data['withdrawn_at'] = null;
        }

        try {
            // Check balance before save - use user_affiliators table balance
            // $db = \Config\Database::connect();
            // $rowBalance = $db->table('user_affiliators')->select('balance')->where('user_id', $postData['user_id'])->get()->getRowArray();
            // $balance = isset($rowBalance['balance']) ? (float)$rowBalance['balance'] : 0.0;
            // if ((float)$data['amount'] > $balance) {
            //     return redirect()->back()->withInput()->with('error', 'Insufficient balance: withdrawal amount exceeds available balance.');
            // }
            if ($id) {
                $this->withdrawalModel->update($id, $data);
                $message = 'Withdrawal updated successfully';
            } else {
                $this->withdrawalModel->insert($data);
                $message = 'Withdrawal created successfully';
            }

            // Recalculate balance for the user
            $this->withdrawalModel->recalculateUserBalance($postData['user_id']);

            return redirect()->to(admin_url() . 'referral/withdrawals')->with('success_message', $message);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error_message', 'Failed to save withdrawal: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $row = $this->withdrawalModel->find($id);
        if (!$row) {
            return $this->response->setJSON(['success' => false, 'message' => 'Withdrawal not found']);
        }

        try {
            $this->withdrawalModel->delete($id);
            // Recalculate balance for user
            $this->withdrawalModel->recalculateUserBalance($row['user_id']);
            return $this->response->setJSON(['success' => true, 'message' => 'Withdrawal deleted']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * AJAX search users for the form
     */
    public function searchUsers()
    {
        $search = $this->request->getGet('q') ?? '';

    $db = \Config\Database::connect();
        $builder = $db->table('view_referrals')
            ->select('user_id as id, fullname as name, email, balance')
            ->limit(10);

        if (!empty($search)) {
            $builder->groupStart()
                ->like('fullname', $search)
                ->orLike('email', $search)
            ->groupEnd();
        }

        $users = $builder->get()->getResultArray();

        return $this->response->setJSON(['success' => true, 'users' => $users]);
    }
}
