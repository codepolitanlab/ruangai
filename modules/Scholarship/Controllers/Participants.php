<?php

namespace Scholarship\Controllers;

use Heroicadmin\Controllers\AdminController;
use Heroicadmin\Modules\Entry\Entry;
use Symfony\Component\Yaml\Yaml;

class Participants extends AdminController
{
    protected $Entry;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->data['page_title'] = 'Participants';
        $this->data['module']     = 'participants';
        $this->data['submodule']  = 'participants';

        $schema = <<<'YAML'
            name: participants
            title: Participants
            base_url: /scholarship/participants
            description: Participants
            icon: people
            table: view_participants
            show_on_table: [user_id, program, fullname, email, whatsapp, progress, tanggal_progress_belajar, total_live_attendance, graduate, status, cert_number, tanggal_daftar, tanggal_klaim_sertifikat, tanggal_expire, birthday, gender, province, city, occupation, work_experience, skill, institution, major, semester, grade, type_of_business, business_duration, education_level, graduation_year, link_business, last_project, reference, referral_code, withdrawal, accept_terms, accept_agreement, is_participating_other_ai_program, bank_name, account_number, account_name, identity_card_image, account_valid]
            hideable: [user_id, program, fullname, email, whatsapp, progress, tanggal_progress_belajar, total_live_attendance, graduate, status, cert_number, tanggal_daftar, tanggal_klaim_sertifikat, tanggal_expire, birthday, gender, province, city, occupation, work_experience, skill, institution, major, semester, grade, type_of_business, business_duration, education_level, graduation_year, link_business, last_project, reference, referral_code, withdrawal, accept_terms, accept_agreement, is_participating_other_ai_program, bank_name, account_number, account_name, identity_card_image, account_valid]
            searchable: [user_id, program, fullname, email, whatsapp, progress, tanggal_progress_belajar, total_live_attendance, graduate, status, cert_number, tanggal_daftar, tanggal_klaim_sertifikat, tanggal_expire, birthday, gender, province, city, occupation, work_experience, skill, institution, major, semester, grade, type_of_business, business_duration, education_level, graduation_year, link_business, last_project, reference, referral_code, withdrawal, accept_terms, accept_agreement, is_participating_other_ai_program, bank_name, account_number, account_name, identity_card_image, account_valid]
            sortable: [user_id, program, fullname, email, whatsapp, progress, tanggal_progress_belajar, total_live_attendance, graduate, status, cert_number, tanggal_daftar, tanggal_klaim_sertifikat, tanggal_expire, birthday, gender, province, city, occupation, work_experience, skill, institution, major, semester, grade, type_of_business, business_duration, education_level, graduation_year, link_business, last_project, reference, referral_code, withdrawal, accept_terms, accept_agreement, is_participating_other_ai_program, bank_name, account_number, account_name, identity_card_image, account_valid]
            default_sorting: [id,asc]
            rowsPerPage: 10
            fields:
                id:    
                    name: id
                    label: ID
                user_id:
                    name: user_id
                    label: user_id
                program:
                    name: program
                    type: text
                    label: Program
                    rules: required
                fullname:
                    name: fullname
                    type: text
                    label: Name
                    rules: required
                email:
                    name: email
                    type: email
                    label: Email
                    rules: required
                whatsapp:
                    name: whatsapp
                    type: text
                    label: Whatsapp
                    rules: required|numeric
                progress:
                    name: progress
                    type: text
                    label: progress
                    rules: required
                tanggal_progress_belajar:
                    name: tanggal_progress_belajar
                    type: date
                    label: tanggal_progress_belajar
                    rules: required
                total_live_attendance:
                    name: total_live_attendance
                    type: text
                    label: total_live_attendance
                    rules: required|numeric
                graduate:
                    name: graduate
                    type: text
                    label: graduate
                    rules: required|numeric
                status:
                    name: status
                    type: text
                    label: Status
                    rules: required
                cert_number:
                    name: cert_number
                    type: text
                    label: cert_number
                    rules: required|numeric
                tanggal_daftar:
                    name: tanggal_daftar
                    type: date
                    label: Joined At
                    rules: required
                tanggal_klaim_sertifikat:
                    name: tanggal_klaim_sertifikat
                    type: date
                    label: tanggal_klaim_sertifikat
                    rules: required
                tanggal_expire:
                    name: tanggal_expire
                    type: date
                    label: tanggal_expire
                    rules: required
                birthday:
                    name: birthday
                    type: date
                    label: birthday
                    rules: required
                gender:
                    name: gender
                    type: text
                    label: gender
                    rules: required
                province:
                    name: province
                    type: text
                    label: province
                    rules: required
                city:
                    name: city
                    type: text
                    label: city
                    rules: required
                occupation:
                    name: occupation
                    type: text
                    label: occupation
                    rules: required
                work_experience:
                    name: work_experience
                    type: text
                    label: work_experience
                    rules: required
                skill:
                    name: skill
                    type: text
                    label: skill
                    rules: required
                institution:
                    name: institution
                    type: text
                    label: institution
                    rules: required
                major:
                    name: major
                    type: text
                    label: major
                    rules: required
                semester:
                    name: semester
                    type: text
                    label: semester
                    rules: required|numeric
                grade:
                    name: grade
                    type: text
                    label: grade
                    rules: required|numeric
                type_of_business:
                    name: type_of_business
                    type: text
                    label: type_of_business
                    rules: required
                business_duration:
                    name: business_duration
                    type: text
                    label: business_duration
                    rules: required
                education_level:
                    name: education_level
                    type: text
                    label: education_level
                    rules: required
                graduation_year:
                    name: graduation_year
                    type: text
                    label: graduation_year
                    rules: required|numeric
                link_business:
                    name: link_business
                    type: text
                    label: link_business
                    rules: required
                last_project:
                    name: last_project
                    type: text
                    label: last_project
                    rules: required
                reference:
                    name: reference
                    type: text
                    label: reference
                    rules: required
                referral_code:
                    name: referral_code
                    type: text
                    label: referral_code
                    rules: required
                withdrawal:
                    name: withdrawal
                    type: text
                    label: withdrawal
                    rules: required
                accept_terms:
                    name: accept_terms
                    type: text
                    label: accept_terms
                    rules: required|numeric
                accept_agreement:
                    name: accept_agreement
                    type: text
                    label: accept_agreement
                    rules: required|numeric
                is_participating_other_ai_program:
                    name: is_participating_other_ai_program
                    type: text
                    label: is_participating_other_ai_program
                    rules: required
                bank_name:
                    name: bank_name
                    type: text
                    label: bank_name
                    rules: required
                account_number:
                    name: account_number
                    type: text
                    label: account_number
                    rules: required|numeric
                account_name:
                    name: account_name
                    type: text
                    label: account_name
                    rules: required
                identity_card_image:
                    name: identity_card_image
                    type: text
                    label: identity_card_image
                    rules: required
                account_valid:
                    name: account_valid
                    type: text
                    label: account_valid
                    rules: required
            YAML;
        $this->Entry = new Entry(Yaml::parse($schema));
        // dd($this->Entry);
    }

    public function index()
    {
        // Response with table body via ajax
        if ($this->request->getGet('tableBody')) {
            return $this->Entry->tableBody();
        }

        // Deliver table template
        $this->data['table'] = $this->Entry->table();

        return view('Scholarship\Views\participants\index', $this->data);
    }

    public function add()
    {
        $this->data['page_title'] = 'Tambah Participants';

        // Insert postdata
        if ($postData = $this->request->getPost()) {
            $id = $this->Entry->insert($postData);
            if (! $id) {
                return redirect()->back()->withInput();
            }

            if ($postData['save_and_exit'] ?? null) {
                return redirect()->to(urlScope() . '/scholarship/participants');
            }

            return redirect()->to(urlScope() . '/scholarship/participants/' . $id . '/edit');
        }

        $this->data['form'] = $this->Entry->form();

        return view('Scholarship\Views\events\form', $this->data);
    }

    public function edit($id)
    {
        $this->data['page_title'] = 'Edit Participants';

        // Update postdata
        if ($postData = $this->request->getPost()) {
            $result = $this->Entry->update($id, $postData);
            if (! $result) {
                return redirect()->back()->withInput();
            }

            if ($postData['save_and_exit'] ?? null) {
                return redirect()->to(urlScope() . '/scholarship/participants');
            }

            return redirect()->to(urlScope() . '/scholarship/participants/' . $id . '/edit');
        }

        $this->data['form'] = $this->Entry->form($id);

        return view('Scholarship\Views\participants\form', $this->data);
    }

    public function delete($id)
    {
        $this->Entry->delete($id);

        return redirect()->to(urlScope() . '/scholarship/participants');
    }
}
