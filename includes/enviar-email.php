<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once '../vendor/autoload.php';
require_once 'functions.inc.php'; 
require_once 'conn.php';

if(isset($_POST['submitContact'])){
    $name = $_POST['nome'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Verificar se o email é válido
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['status'] = "O email inserido é inválido.";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit(0);
    }

    // Verificar se o usuário está autenticado
    $idCliente = isset($_SESSION['userid']) ? $_SESSION['userid'] : 0;

    // Create a PHPMailer instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        // Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
        $mail->Username   = 'pastelariacrocancia@gmail.com';        // SMTP username
        $mail->Password   = 'rrnp fqyk pwso rmri';                 // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption
        $mail->Port       = 587;                                    // TCP port to connect to

        // Recipients
        $mail->setFrom('pastelariacrocancia@gmail.com', 'Pastelaria Crocancia');
        $mail->addAddress('pastelariacrocancia@gmail.com', 'Pastelaria Crocancia'); // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject . ' sobre a Pastelaria Crocancia';

        // Email body
        $email_body = '
        <!DOCTYPE html>
        <html lang="pt">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f2f2f2;
                    padding: 20px;
                }
                .email-container {
                    max-width: 600px;
                    margin: auto;
                    background-color: #fff;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    overflow: hidden;
                    font-size: 16px;
                }
                .email-header {
                    background-color: #cd9452;
                    color: #fff;
                    padding: 20px;
                    text-align: center;
                    font-size: 24px;
                }
                .email-content {
                    padding: 20px;
                }
                .email-content p {
                    margin: 5px 0;
                }
                .thank-you {
                    background-color: #f9f9f9;
                    padding: 10px;
                    border-radius: 5px;
                }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="email-header">
                    <p><strong>Assunto:</strong> ' . $subject . '</p>
                </div>
                <div class="email-content">
                    <p><strong>Nome:</strong> ' . $name . '</p>
                    <p><strong>Email:</strong> ' . $email . '</p>
                    <div class="thank-you">
                        <p><strong>Mensagem:</strong></p>
                        <p>' . $message . '</p>
                    </div>
                </div>
            </div>
        </body>
        </html>
        ';

        $mail->Body = $email_body;

        // Send email
        if($mail->send()){
            // Inserir mensagem no banco de dados após enviar o e-mail
            $idMensagem = inserirMensagem($db, $idCliente, $subject, $message);
            if($idMensagem) {
                $_SESSION['status'] = "Obrigado por nos contactar - Pastelaria Crocancia. ID da mensagem: $idMensagem";
            } else {
                $_SESSION['status'] = "Erro ao enviar mensagem. Por favor, tente novamente mais tarde.";
            }
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit(0);
        } else {
            $_SESSION['status'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit(0);
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    header('Location: contact.php');
    exit();
}

?>
