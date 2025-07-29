<?php

namespace App\Libraries;

use PHPMailer\PHPMailer\PHPMailer;
use RuntimeException;

class EmailSender
{
    protected string $templatePath;
    protected string $message;

    public function __construct()
    {
        $this->templatePath = setting('Email.templatePath');
    }

    public function setTemplate($templateName, $data = [])
    {
        $this->message = view($this->templatePath . $templateName, $data);

        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function send($to, $subject, $message = null, $debug = 0)
    {
        if (! $message && ! $this->message) {
            throw new RuntimeException('Message is empty');
        }

        $mail        = new PHPMailer($debug ? true : false);
        $EmailConfig = new \Config\Email();

        try {
            $mail->SMTPDebug = $debug;
            $mail->isSMTP();
            $mail->Host       = $EmailConfig->SMTPHost;
            $mail->SMTPAuth   = $EmailConfig->SMTPPort === 1025 ? false : true;
            $mail->Username   = $EmailConfig->SMTPUser;
            $mail->Password   = $EmailConfig->SMTPPass;
            $mail->SMTPSecure = $EmailConfig->SMTPPort === 1025 ? false : $EmailConfig->SMTPCrypto;
            $mail->Port       = $EmailConfig->SMTPPort;

            $mail->setFrom($EmailConfig->fromEmail, $EmailConfig->fromName);
            $mail->addAddress($to);
            $mail->isHTML(true);

            $mail->Subject = $subject;
            $mail->Body    = $message ?? $this->message;

            $mail->send();

            return ['success' => true];
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            return ['success' => false, 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"];
        }
    }
}
