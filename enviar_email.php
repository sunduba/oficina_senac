<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);
// transforma o json recebido em um array = estrutura de dados
$dados = json_decode(file_get_contents('php://input'), true);
// var_dump($dados);
// exit;

try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'madu.heycherries@gmail.com';                     //SMTP username
    $mail->Password   = 'bpbs zeah tuwr pdyk';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($dados['email'], $dados['nome']);
    $mail->addAddress('2710mariana@gmail.com', 'fx');     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Email enviado do site SENAC';
    $mail->Body    = 'A mensagem <b>' . $dados['mensagem'] . '</b>'.
    '<br> Enviado por: <b>' . $dados['nome'] . '</b> com o email <b>' . $dados['email'] .
    '</b> e telefone <b>' . $dados['telefone'] . '</b>';
    $mail->AltBody = 'Texto alternativo para clientes de email que não suportam HTML';

    $mail->send();
    http_response_code(200);
    echo json_encode(['success' => 'mensagem enviada com sucesso']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'não foi possível enviar a mensagem ' . $e->getMessage()]);
}