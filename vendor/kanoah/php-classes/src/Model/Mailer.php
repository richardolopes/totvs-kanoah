<?php

namespace Kanoah\Model;

use \Kanoah\Model;
use \PHPMailer\PHPMailer\PHPMailer;

class Mailer extends Model
{
    public function __construct($subject, $html)
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = "automacaobot@gmail.com";
        $mail->Password = PASSWORD_EMAIL;
        $mail->setFrom('automacaobot@gmail.com', utf8_decode('Não responder'));

        $mail->addAddress('richardxlopes@gmail.com       ', 'Richard Lopes                     ');
        $mail->addAddress('richard.lopes@totvs.com.br    ', 'Richard Lopes                     ');
        // $mail->addAddress('SQUAD.Fin@totvs.com.br ', 'SQUAD FIN');

        $mail->Subject = utf8_decode($subject);
        $mail->msgHTML($html);

        if (!$mail->send()) {
            return "Mailer Error: " . $mail->ErrorInfo;
        } else {
            return "Message sent!";
        }
    }

}
