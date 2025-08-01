<?php

namespace App\Pages\zpanel\user\scholarship\form;

use App\Controllers\BaseController;
use Exception;

class PageController extends BaseController
{
    public function getIndex()
    {
        $data['page_title'] = 'Scholarship Form';

        // Ambil ID dari URL jika ada
        $id = $this->request->getGet('id');
        if ($id) {
            // Mode Edit: Ambil data scholarship
            $scholarshipModel = new \App\Models\ScholarshipParticipantModel();
            $data['user']     = $scholarshipModel->where('id', $id)
                ->where('deleted_at', null)
                ->asObject()
                ->first();

            if (! $data['user']) {
                session()->setFlashdata('error', 'Data tidak ditemukan');

                return redirect()->to('/zpanel/user/scholarship');
            }

            $data['page_title'] = 'Edit Scholarship';
        }

        return pageView('zpanel/user/scholarship/form/index', $data);
    }

    public function postIndex()
    {
        $id = $this->request->getPost('id');

        // Kumpulkan semua data dari form
        $data = [
            'program'          => $this->request->getPost('program'),
            'fullname'         => $this->request->getPost('fullname'),
            'email'            => $this->request->getPost('email'),
            'whatsapp'         => $this->request->getPost('whatsapp'),
            'birthday'         => $this->request->getPost('birthday'),
            'gender'           => $this->request->getPost('gender'),
            'province'         => $this->request->getPost('province'),
            'city'             => $this->request->getPost('city'),
            'occupation'       => $this->request->getPost('occupation'),
            'work_experience'  => $this->request->getPost('work_experience'),
            'skill'            => $this->request->getPost('skill'),
            'institution'      => $this->request->getPost('institution'),
            'major'            => $this->request->getPost('major'),
            'semester'         => $this->request->getPost('semester'),
            'grade'            => $this->request->getPost('grade'),
            'type_of_business' => $this->request->getPost('type_of_business'),
            'education_level'  => $this->request->getPost('education_level'),
            'graduation_year'  => $this->request->getPost('graduation_year'),
            'link_business'    => $this->request->getPost('link_business'),
            'last_project'     => $this->request->getPost('last_project'),
            'reference'        => $this->request->getPost('reference'),
            'referral_code'    => $this->request->getPost('referral_code'),
            'status'           => $this->request->getPost('status'),
            'accept_terms'     => $this->request->getPost('accept_terms') ? 1 : 0,
            'accept_agreement' => $this->request->getPost('accept_agreement') ? 1 : 0,
        ];

        $scholarshipModel = new \App\Models\ScholarshipParticipantModel();

        try {
            if ($id) {
                // Update data
                $scholarshipModel->update($id, $data);
            } else {
                // Insert data baru
                $scholarshipModel->insert($data);
            }

            session()->setFlashdata('success', 'Data berhasil disimpan');

            return redirect()->to('/zpanel/user/scholarship');
        } catch (Exception $e) {
            session()->setFlashdata('error', 'Gagal menyimpan data: ' . $e->getMessage());

            return redirect()->back()->withInput();
        }
    }

    public function postDelete()
    {
        $id               = $this->request->getPost('id');
        $scholarshipModel = new \App\Models\ScholarshipParticipantModel();

        try {
            $scholarshipModel->update($id, ['deleted_at' => date('Y-m-d H:i:s')]);
            session()->setFlashdata('success', 'Data berhasil dihapus');
        } catch (Exception $e) {
            session()->setFlashdata('error', 'Gagal menghapus data: ' . $e->getMessage());
        }

        return redirect()->to('/zpanel/user/scholarship');
    }
}
