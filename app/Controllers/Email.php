<?php

namespace App\Controllers;

/**
 * Controller untuk preview tampilan template email
 * endpoint: email/preview/[template_name]
 * Template disimpan di folder Views/emails/
 */
class Email extends BaseController
{
    public function preview($template = 'sample')
    {
        $EmailSender = new \App\Libraries\EmailSender();

        $EmailSender->setTemplate($template);

        return $EmailSender->getMessage();
    }
}
