<?php

namespace App\Pages\zpanel\test;

use App\Controllers\BaseController;

class PageController extends BaseController
{
    public function getIndex()
    {
        $data = [];

        return pageView('zpanel/test/index', $data);
    }

    public function getForm()
    {
        $schema = [
            [
                'name'        => 'name',
                'label'       => 'Name',
                'type'        => 'text',
                'placeholder' => 'Your name',
                'rules'       => 'required',
            ],
            [
                'name'        => 'email',
                'label'       => 'Email',
                'type'        => 'email',
                'placeholder' => 'Your email',
                'rules'       => 'required',
            ],
            [
                'name'  => 'password',
                'label' => 'Password',
                'type'  => 'password',
                'rules' => 'required',
            ],
            [
                'name'    => 'hobi',
                'label'   => 'Hobi',
                'type'    => 'checkbox',
                'rules'   => 'required',
                'options' => [
                    'makan' => 'Makan',
                    'minum' => 'Minum',
                    'tidur' => 'Tidur',
                ],
                'default' => ['makan'],
            ],
            [
                'name'   => 'content',
                'label'  => 'Konten',
                'type'   => 'code',
                'rules'  => 'required',
                'mode'   => 'html',
                'height' => 400,
            ],
            [
                'name'  => 'theme_color',
                'label' => 'Warna Tema',
                'type'  => 'color',
                'rules' => 'required',
            ],
            [
                'name'  => 'harga',
                'label' => 'Harga',
                'type'  => 'currency',
                'rules' => 'required',
            ],
            [
                'name'    => 'tanggal',
                'label'   => 'Tanggal',
                'type'    => 'date',
                'rules'   => 'required',
                'default' => '2024-02-27',
            ],
            [
                'name'    => 'tanggal_mulai',
                'label'   => 'Tanggal Mulai',
                'type'    => 'date_manual',
                'rules'   => 'required',
                'default' => '2024-02-27',
            ],
            [
                'name'    => 'tanggal_berakhir',
                'label'   => 'Tanggal Berakhir',
                'type'    => 'date_manual',
                'rules'   => 'required',
                'default' => '2025-03-27',
            ],
            [
                'name'    => 'waktu',
                'label'   => 'Waktu',
                'type'    => 'datetime',
                'rules'   => 'required',
                'default' => '2024-02-27 00:59:00',
            ],
            [
                'name'    => 'jadwal',
                'label'   => 'Jadwal',
                'type'    => 'dropdown',
                'rules'   => 'required',
                'options' => [
                    'pagi'  => 'Pagi',
                    'siang' => 'Siang',
                    'sore'  => 'Sore',
                    'malam' => 'Malam',
                ],
            ],
        ];

        $form = [];

        foreach ($schema as $i => $field) {
            $FieldClass        = '\\App\\Libraries\\FormFields\\' . $field['type'] . '\\' . $this->toClassName($field['type']) . 'Field';
            $fieldObject       = new $FieldClass($field);
            $form[$i]          = $fieldObject->getProps();
            $form[$i]['class'] = $fieldObject;
        }

        $pageTitle = 'Test';

        return pageView('zpanel/test/index', ['page_title' => $pageTitle, 'form' => $form]);
    }

    private function toClassName(string $str): string
    {
        return preg_replace_callback('/(?:^|_)([a-z])/', static fn ($matches) => strtoupper($matches[1]), $str);
    }

    public function postForm()
    {
        $data = $this->request->getPost();
        dd($data);
    }
}
