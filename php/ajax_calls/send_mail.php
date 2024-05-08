<?php session_start();
    if(!isset($_SESSION['role'])) return;
    
    require '../php_mailer/src/PHPMailer.php';
    require '../php_mailer/src/SMTP.php';
    require '../php_mailer/src/Exception.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    // $mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'ttt.automailer@gmail.com';
    $mail->Password = 'lxwz kzje cfyz pmzc';
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
        );
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('ttt.automailer@gmail.com', 'TTT');
    $mail->addAddress($_POST['userMail']);
    $mail->Subject = $_POST['subject'];
    $mail->Body = $_POST['message'];
    $mail->send();

    echo isset($_POST['success']) ? $_POST['success'] : "";
?>