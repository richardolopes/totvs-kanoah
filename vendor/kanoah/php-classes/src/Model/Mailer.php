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

        $mail->addAddress('richard.lopes@totvs.com.br    ', 'Richard Lopes                     ');
        $mail->addAddress('iolanda.cipriano@totvs.com.br ', 'Iolanda Cipriano                  ');
        $mail->addAddress('alberto.jose@totvs.com.br     ', 'Alberto Jose Teixeira Filho       ');
        $mail->addAddress('ana.nascimento@totvs.com.br   ', 'Ana Paula Nascimento Silva        ');
        $mail->addAddress('douglas.oliveira@totvs.com.br ', 'Douglas de Oliveira Homem         ');
        $mail->addAddress('douglas.souza@totvs.com.br    ', 'Douglas Goncalves de Souza        ');
        $mail->addAddress('eliana.gomes@totvs.com.br     ', 'Eliana Gomes de Assis Urbaneja    ');
        $mail->addAddress('fernando.griecco@totvs.com.br ', 'Fernando Augusto Griecco Navarro  ');
        $mail->addAddress('francisco.carmo@totvs.com.br  ', 'Francisco Do Carmo de Oliveira    ');
        $mail->addAddress('jose.gavetti@totvs.com.br     ', 'Jose William Mendasoli Gavetti    ');
        $mail->addAddress('marjorie.taki@totvs.com.br    ', 'Marjorie Yuri Taki                ');
        $mail->addAddress('renato.ito@totvs.com.br       ', 'Renato Goes Ito                   ');
        $mail->addAddress('rodrigo.oliveira@totvs.com.br ', 'Rodrigo Alexandre de Oliveira_    ');
        $mail->addAddress('rafael.stefano@totvs.com.br   ', 'Rafael Stefano Holland Rondon     ');
        $mail->addAddress('luis.geraldo@totvs.com.br     ', 'Luis Geraldo                      ');

        $mail->Subject = utf8_decode('Automação: ' . $subject);

        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $mail->msgHTML($html);

        //Attach an image file
        // $mail->addAttachment('images/phpmailer_mini.png');

        //send the message, check for errors
        if (!$mail->send()) {
            return "Mailer Error: " . $mail->ErrorInfo;
        } else {
            return "Message sent!";
        }
    }

}
