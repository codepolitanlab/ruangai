<?php

namespace Scholarship\Controllers;

use Heroicadmin\Controllers\AdminController;
use Heroicadmin\Modules\Entry\Entry;
use Symfony\Component\Yaml\Yaml;

class Referral extends AdminController
{
    protected $Entry;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->data['page_title'] = 'Referral';
        $this->data['module']     = 'referral';
        $this->data['submodule']  = 'referral';

        $schema = <<<'YAML'
            name: referral
            title: Referral
            base_url: /scholarship/referral
            description: Referral
            icon: people
            table: view_referrals
            show_on_table: [ user_id, program, fullname, email, whatsapp, referral_code, referral_code_comentor, reference, graduate, total_referred_lulus, withdrawal, bank_name, account_number, account_name, account_valid, identity_card_image]
            hideable: [ user_id, program, fullname, email, whatsapp, referral_code, referral_code_comentor, reference, graduate, total_referred_lulus, withdrawal, bank_name, account_number, account_name, account_valid, identity_card_image]
            searchable: [ user_id, program, fullname, email, whatsapp, referral_code, referral_code_comentor, reference, graduate, total_referred_lulus, withdrawal, bank_name, account_number, account_name, account_valid, identity_card_image]
            sortable: [ user_id, program, fullname, email, whatsapp, referral_code, referral_code_comentor, reference, graduate, total_referred_lulus, withdrawal, bank_name, account_number, account_name, account_valid, identity_card_image]
            default_sorting: [id,asc]
            rowsPerPage: 10
            fields:
                id:    
                    name: id
                    label: ID
                user_id:
                    name: user_id
                    label: User ID
                    rules: required
                program:
                    name: program
                    type: text
                    label: Program
                    rules: required
                fullname:
                    name: fullname
                    type: text
                    label: Fullname
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
                referral_code:
                    name: referral_code
                    type: text
                    label: Referral Code
                    rules: required
                referral_code_comentor:
                    name: referral_code_comentor
                    type: text
                    label: referral_code_comentor
                    rules: required
                reference:
                    name: reference
                    type: text
                    label: Reference
                    rules: required
                graduate:
                    name: graduate
                    type: text
                    label: Graduate
                    rules: required|numeric
                total_referred_lulus:
                    name: total_referred_lulus
                    type: text
                    label: total_referred_lulus
                    rules: required|numeric
                withdrawal:
                    name: withdrawal
                    type: text
                    label: Withdrawal
                    rules: required
                bank_name:
                    name: bank_name
                    type: text
                    label: Bank Name
                    rules: required
                account_number:
                    name: account_number
                    type: text
                    label: Account Number
                    rules: required|numeric
                account_name:
                    name: account_name
                    type: text
                    label: Account Name
                    rules: required
                account_valid:
                    name: account_valid
                    type: text
                    label: Account Valid
                identity_card_image:
                    name: identity_card_image
                    type: text
                    label: Identity Card Image
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

        return view('Scholarship\Views\referral\index', $this->data);
    }

    public function add()
    {
        $this->data['page_title'] = 'Tambah referral';

        // Insert postdata
        if ($postData = $this->request->getPost()) {
            $id = $this->Entry->insert($postData);
            if (! $id) {
                return redirect()->back()->withInput();
            }

            if ($postData['save_and_exit'] ?? null) {
                return redirect()->to(urlScope() . '/scholarship/referral');
            }

            return redirect()->to(urlScope() . '/scholarship/referral/' . $id . '/edit');
        }

        $this->data['form'] = $this->Entry->form();

        return view('Scholarship\Views\referral\form', $this->data);
    }

    public function edit($id)
    {
        $this->data['page_title'] = 'Edit referral';

        // Update postdata
        if ($postData = $this->request->getPost()) {
            $result = $this->Entry->update($id, $postData);
            if (! $result) {
                return redirect()->back()->withInput();
            }

            if ($postData['save_and_exit'] ?? null) {
                return redirect()->to(urlScope() . '/scholarship/referral');
            }

            return redirect()->to(urlScope() . '/scholarship/referral/' . $id . '/edit');
        }

        $this->data['form'] = $this->Entry->form($id);

        return view('Scholarship\Views\referral\form', $this->data);
    }

    public function delete($id)
    {
        $this->Entry->delete($id);

        return redirect()->to(urlScope() . '/scholarship/referral');
    }
}
