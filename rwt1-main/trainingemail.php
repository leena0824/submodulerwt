<?php
session_start();
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
    $course = $_POST['course'];
  

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
        $bodyContent   = "<h3><B>Here is a new Training Registration</B></h3><hr><hr>Name: $name<br>Email: $email<br>Course: $course ";
           $mail->Body = $bodyContent;
           $mail->send();
         header('location: training_placement.php');
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

include("connection.php");
     if(isset($_POST["submit"])){

      $name=$_POST["name"];
      $email = $_POST["email"];
      $course = $_POST["course"];
     
     $query="INSERT INTO training_placement VALUES('','$name','$email','$course' )";
     mysqli_query($conn,$query);
     echo
     "<script> alert('Data Inserted Successfully');
     </script>";
  }
?>