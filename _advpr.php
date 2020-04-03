<?php

use \Kanoah\Page;

$app->get("/automacao", function () {
    $page = new Page();
    $page->setTpl("email", array());
});

function maiorData($range)
{
    $aux = '';

    for ($i = 0; $i < count($range); $i++) {
        if ($range[$i]->value > $aux) {
            $aux = $range[$i]->value;
        }
    }

    return $aux;
}

function stringParaData($string)
{
    return substr($string, 6, 8) . '/' . substr($string, 4, 2) . '/' . substr($string, 0, 4);
}

function montaTexto($erros)
{
    $rotinas = [];
    $qtd = count($erros);

    $texto = "Quantidade de quebras: $qtd \n";
    for ($i = 0; $i < $qtd; $i++) {
        @$rotinas[$erros[$i]->rotina][0] .= 'CT' . explode('-', $erros[$i]->erro)[0];
        @$rotinas[$erros[$i]->rotina][1] += 1;
    }
    $qtdRot = count($rotinas);

    $texto .= "Quantidade de fontes : $qtdRot \n\n";
    for ($i = 0; $i < $qtdRot; $i++) {
        $rotina = key($rotinas);
        $texto .= str_pad($rotina, 8) . ' = ' . str_pad($rotinas[$rotina][1], 2) . ' Quebra(s) (' . trim($rotinas[$rotina][0]) . ")\n";
        next($rotinas);
    }

    return $texto;
}
// /*
// http://10.171.78.41:8006/rest/filtrosportal/releas/homolog -> (RELEASE) 12.1.025
// http://10.171.78.41:8006/rest/filtrosportal/identi/homolog/12.1.023 -> (IDENTIFICADOR) RPO D-1
// http://10.171.78.41:8006/rest/filtrosportal/pais/homolog/12.1.023/RPO_D-1 -> (PAIS) BRA
// http://10.171.78.41:8006/rest/filtrosportal/BRA/execDay/12.1.023/RPO_D-1/Todas -> (DATA EXECUÇÃO) 20200128
//  */
// define('RELEASE', 'http://10.171.78.41:8006/rest/filtrosportal/releas/homolog');
// define('RPOS', 'http://10.171.78.41:8006/rest/filtrosportal/identi/homolog/'); // 12.1.023
// define('PAIS', 'http://10.171.78.41:8006/rest/filtrosportal/pais/homolog/'); // 12.1.023/RPO_D-1
// define('DATAS', 'http://10.171.78.41:8006/rest/filtrosportal/BRA/execDay/'); // 12.1.023/RPO_D-1/Todas
// define('EXECUCAO', 'http://10.171.78.41:8006/rest/acompanhamentoExecucaoD1/Detail/FINANCEIRO/BRA/'); // 12.1.027/20200402/RPO_D-1/Todas

// $ch = curl_init(RELEASE);
// curl_setopt($ch, CURLOPT_HTTPGET, true);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// $response = json_decode(curl_exec($ch));
// curl_close($ch);

// $_SESSION['RELEASE'] = $response;
// $release = $_SESSION['RELEASE'][4]->value;

// $ch = curl_init(RPOS . $release);
// curl_setopt($ch, CURLOPT_HTTPGET, true);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// $response = json_decode(curl_exec($ch));
// curl_close($ch);

// $_SESSION['RPOS'] = $response;
// $rpo = $_SESSION['RPOS'][0]->value;

// $ch = curl_init(DATAS . $release . '/' . $rpo . '/Todas');
// curl_setopt($ch, CURLOPT_HTTPGET, true);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// $response = json_decode(curl_exec($ch));
// curl_close($ch);

// $_SESSION['DATAS'] = $response;
$data = maiorData($_SESSION['DATAS']);

// $ch = curl_init(EXECUCAO . $release . '/' . $data . '/' . $rpo . '/Todas');
// curl_setopt_array($ch, [
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_POST => true,
//     CURLOPT_POSTFIELDS => [
//         'user' => '',
//     ],
// ]);
// $response = json_decode(curl_exec($ch));
// curl_close($ch);

// $_SESSION['EXECUCAO'] = $response;
// $execucao = $_SESSION['EXECUCAO'];

// $texto = "Release $release  |  " . stringParaData($data) . " \n";
// $texto .= montaTexto($execucao);
// echo '<textarea cols=150 rows=50>' . $texto . '</textarea>';

// $_SESSION['TEXTO'] = $texto;
// $_SESSION['EXEC_DIARIO'] = time();

/*

EMAIL

 */

//Create a new PHPMailer instance
$mail = new PHPMailer\PHPMailer\PHPMailer();

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "automacaobot@gmail.com"; // RICO L 714

//Password to use for SMTP authentication
$mail->Password = "123456789Xx!";

//Set who the message is to be sent from
$mail->setFrom('automacaobot@gmail.com', 'Richard Lopes');

//Set an alternative reply-to address
//$mail->addReplyTo('replyto@example.com', 'First Last');

//Set who the message is to be sent to
$mail->addAddress('richardxlopes@gmail.com', 'Richard Lopes');
$mail->addAddress('richard.lopes@totvs.com.br', 'Richard Lopes');

//Set the subject line
$mail->Subject = utf8_decode('AUTOMAÇÃO ') . stringParaData($data);

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML(file_get_contents('views/contents.html'), __DIR__);

//Replace the plain text body with one created manually
$mail->AltBody = 'Teste.';

//Attach an image file
// $mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
    //Section 2: IMAP
    //Uncomment these to save your message in the 'Sent Mail' folder.
    #if (save_mail($mail)) {
    #    echo "Message saved!";
    #}
}
