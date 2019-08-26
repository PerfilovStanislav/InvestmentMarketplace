<?php

namespace Libraries;

use Models\MailMessage;
use PHPMailer\PHPMailer;

class Mail
{
    public function sendMail(MailMessage $mailMessage) {

        $mail = new PHPMailer(DEBUG);

        try {

            $mail->SMTPDebug = DEBUG ? 0/*4*/ : 0;
            $mail->isSMTP();
            $mail->isHTML(true);
            $mail->CharSet = PHPMailer::CHARSET_UTF8;
            $mail->Host = 'smtp.yandex.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'no-reply@richinme.com';
            $mail->Password = '#eD4Rf%tG';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('no-reply@richinme.com', 'RichInMe');

            $mail->addAddress($mailMessage->receiverEmail, $mailMessage->receiverName);

            $mail->Subject = $mailMessage->subject;
            $mail->Body    = $mailMessage->body;

            $mail->send();
        } catch (\Exception $e) {
            echo 'Не возможно отправить письмо. Ошибка: ', $mail->ErrorInfo;
        }

    }
}