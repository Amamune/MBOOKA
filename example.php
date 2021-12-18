<?php
require_once('PHPMailer/PHPMailerAutoload.php');

if (isset($_POST['sendMailBtn'])) {
    
    $email = new PHPMailer();
    $email->isSMTP();
    $email->SMTPAuth = true;
    $email->SMTPSecure = 'ssl';
    $email->Host = 'smtp.gmail.com';
    $email->Port = '465';
    $email->isHTML();
    $email->Username = 'torchic1524@gmail.com';
    $email->Password = 'qswgavgxjawnchya';
    $email->SetFrom('torchic1524@gmail.com','Movie Booka'); 
    $email->Subject = $_POST['subject'];
    $email->Body = $_POST['message'];
  $email->AddAddress($_POST['toEmail']);
//  $email->AddAddress('torchic1524@gmail.com');
    $email->send();

    echo '<script>alert("Email sent successfully !")</script>';
    echo '<script>window.location.href="index.php";</script>';
}

?>