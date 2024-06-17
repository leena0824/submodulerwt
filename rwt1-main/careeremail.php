<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


if(isset($_POST['submit']))
{
   //$filename=$_FILES["File"]["name"];
    $name=$_POST['name'];
    $email = $_POST['email'];
    $phone=$_POST['phone'];
    $domain = $_POST['domain'];
    $msg=$_POST['msg'];
  

    $mail = new PHPMailer(true);

    try {
        
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'shrutisuryawanshi343@gmail.com'; 
        $mail->Password   = 'recfcqcosvljttno';                                                    
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        //Recipients
        $mail->setFrom('shrutisuryawanshi343@gmail.com', 'Training Registration');
        $mail->addAddress('shrutisuryawanshi343@gmail.com', 'Admin');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Training Registration';
        $bodyContent   = "<h3><B><U><Here is a New Applicant Information</U></B></h3><hr><hr>Name: $name<br>Email: $email<br>Phone: $phone<br>Domain:$domain<br>What's:$msg ";
           $mail->Body = $bodyContent;
           $mail->send();
      header('location:careers.php');
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

include("connection.php");
     if(isset($_POST["submit"])){

      $name=$_POST["name"];
      $email = $_POST["email"];
      $phone = $_POST["phone"];
      $domain=$_POST["domain"];
      $msg=$_POST['msg'];

     
     $query="INSERT INTO career VALUES('','$name','$email','$phone','$domain','$msg' )";
     mysqli_query($conn,$query);
     echo
     "<script> alert('Data Inserted Successfully');
     </script>";
  }
?>