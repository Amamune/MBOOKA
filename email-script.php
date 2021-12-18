<?php
require_once('PHPMailer/PHPMailer.php');
require_once('PHPMailer/Exception.php');
require_once('PHPMailer/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

    $email = new PHPMailer();
    $email->isSMTP();
    $email->SMTPAuth = true;
    $email->SMTPSecure = 'ssl';
    $email->Host = 'smtp.gmail.com';
    $email->Port = '465';
    $email->isHTML();
    $email->Username = 'customerconcernmbooka@gmail.com';
    $email->Password = 'bqbqizuysmiflqxj';
    $email->SetFrom('customerconcernmbooka@gmail.com',"From: ".$_POST['toEmail']); 
    $email->Subject = $_POST['subject'];
    $email->Body = $_POST['message'];
    
    $email->AddAddress('torchic1524@gmail.com');
    $email->send();

    echo '<script>alert("Email sent successfully !")</script>';
    echo '<script>window.location.href="index.php";</script>';


?>