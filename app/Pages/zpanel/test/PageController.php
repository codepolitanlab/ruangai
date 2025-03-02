<?php namespace App\Pages\zpanel\test;

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
            // [
            //     'name' => 'name',
            //     'label' => 'Name',
            //     'type' => 'text',
            //     'placeholder' => 'Your name',
            //     'rules' => 'required',
            // ],
            // [
            //     'name' => 'email',
            //     'label' => 'Email',
            //     'type' => 'email',
            //     'placeholder' => 'Your email',
            //     'rules' => 'required',
            // ],
            // [
            //     'name' => 'password',
            //     'label' => 'Password',
            //     'type' => 'password',
            //     'rules' => 'required',
            // ],
            // [
            //     'name' => 'hobi',
            //     'label' => 'Hobi',
            //     'type' => 'checkbox',
            //     'rules' => 'required',
            //     'options' => [
            //         'makan' => 'Makan',
            //         'minum' => 'Minum',
            //         'tidur' => 'Tidur',
            //     ],
            //     'default' => ['makan'],
            // ],
            // [
            //     'name' => 'content',
            //     'label' => 'Konten',
            //     'type' => 'code',
            //     'rules' => 'required',
            //     'mode' => 'html',
            //     'height' => 400,
            // ],
            // [
            //     'name' => 'theme_color',
            //     'label' => 'Warna Tema',
            //     'type' => 'color',
            //     'rules' => 'required',
            // ],


        ];

        $form = [];
        foreach ($schema as $i => $field) {
            $FieldClass = "\\App\\Libraries\\FormFields\\" . $field['type'] . "\\" . $this->toClassName($field['type']) . "Field";
            $fieldObject = new $FieldClass($field);
            $form[$i] = $fieldObject->getProps();
            $form[$i]['class'] = $fieldObject;
        }
        
        $pageTitle = 'Test';
        return pageView('zpanel/test/index', ['page_title' => $pageTitle, 'form' => $form]);
    }

    private function toClassName(string $str): string {
        return preg_replace_callback('/(?:^|_)([a-z])/', function ($matches) {
            return strtoupper($matches[1]);
        }, $str);
    }
}
