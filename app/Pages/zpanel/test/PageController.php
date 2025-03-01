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
            //     'required' => true,
            // ],
            // [
            //     'name' => 'email',
            //     'label' => 'Email',
            //     'type' => 'text',
            //     'required' => true,
            // ],
            // [
            //     'name' => 'password',
            //     'label' => 'Password',
            //     'type' => 'text',
            //     'required' => true,
            // ],
            // [
            //     'name' => 'hobi',
            //     'label' => 'Hobi',
            //     'type' => 'checkbox',
            //     'required' => true,
            //     'options' => [
            //         'makan' => 'Makan',
            //         'minum' => 'Minum',
            //         'tidur' => 'Tidur',
            //     ],
            //     'default' => ['makan'],
            // ],
            [
                'name' => 'content',
                'label' => 'Konten',
                'type' => 'code',
                'required' => true,
                'mode' => 'html',
                'height' => 400,
            ],

        ];

        foreach ($schema as $field) {
            $FieldClass = "\\App\\Libraries\\FormFields\\" . $field['type'] . "\\" . ucfirst($field['type']) . "Field";
            $fieldObj = new $FieldClass($field);
            echo $fieldObj->renderInput();
            // dd($fieldObj->getAttributes(), $fieldObj->renderInput());
        }
    }
}
