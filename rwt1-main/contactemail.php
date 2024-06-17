<?php
session_start();
include("connection.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if(isset($_POST['submit'])) {
    // Basic form validation
    if(empty($_POST['select_opt']) || empty($_POST['username']) || empty($_POST['surname']) || empty($_POST['email'])
    || empty($_POST['phone']) || empty($_POST['message'])) {
        $_SESSION['status'] = "Please fill out all required fields.";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit(0);
    }
    
    $selectoption = mysqli_real_escape_string($conn, $_POST["select_opt"]);
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $surname = mysqli_real_escape_string($conn, $_POST["surname"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
    $message = mysqli_real_escape_string($conn, $_POST["message"]);
    
    // File upload handling
    $attachment = $_FILES['attachment']['tmp_name'];
    $attachment_name = $_FILES['attachment']['name'];
    $attachment_size = $_FILES['attachment']['size'];
    $attachment_type = $_FILES['attachment']['type'];
    
    // Check if attachment exists and meets criteria
    if(!empty($attachment)){
        // Check file size (10MB max)
        if($attachment_size > 10 * 1024 * 1024) {
            $_SESSION['status'] = "Attachment size exceeds the limit of 10MB.";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit(0);
        }
        
        // Allowed file types
        $allowed_types = array("image/jpeg", "image/png", "application/pdf", "application/msword");
        if(!in_array($attachment_type, $allowed_types)) {
            $_SESSION['status'] = "Invalid attachment type. Allowed types: JPEG, PNG, PDF, DOC.";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit(0);
        }
    }
    
    // SQL query to insert data into database
    $query = "INSERT INTO `contactus` (`select_opt`, `username`, `surname`, `email`, `phone`, `message`, `attachment_name`) VALUES (?,?,?,?,?,?,?)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssss", $selectoption, $username, $surname, $email, $phone, $message, $attachment_name);
    
    if($stmt->execute()) {
        // Send email
        $mail = new PHPMailer(true);
        
        try {
            //Server settings
            $mail->isSMTP(); // Send using SMTP
            $mail->Host = 'smtp.gmail.com'; // SMTP server
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = 'shrutisuryawanshi343@gmail.com'; // SMTP username
            $mail->Password = 'recfcqcosvljttno'; // SMTP password
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption
            $mail->Port = 587; // TCP port to connect to
            
            //Recipients
            $mail->setFrom('shrutisuryawanshi343@gmail.com', 'Your Name');
            $mail->addAddress('shrutisuryawanshi343@gmail.com', 'Recipient Name'); // Add a recipient
            
            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'New Applicant';
            $mail->Body = '<h3>Hello, here is a new applicant information</h3>
                           <h4>select_opt: '.$selectoption.'</h4>
                           <h4>username: '.$username.'</h4>
                           <h4>surname: '.$surname.'</h4>
                           <h4>email: '.$email.'</h4>
                           <h4>phone: '.$phone.'</h4>
                           <h4>message:'.$message.'</h4>';
            
            // Add attachment if provided
            if(!empty($attachment)) {
                $mail->addAttachment($attachment, $attachment_name);
            }
            
            // Send email
            if($mail->send()) {
                $_SESSION['status'] = "Thank you for Applying";
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit(0);
            } else {
                $_SESSION['status'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit(0);
            }
        } catch (Exception $e) {
            $_SESSION['status'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit(0);
        }
    } else {
        $_SESSION['status'] = "Failed to insert data into database";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit(0);
    }
}




                                        
                                        include('connection.php');
                                            if(isset($_POST['submit']))
                                            {
                                              $selectoption = $_POST["select_opt"];
                                              $username = $_POST["username"];
                                              $surname = $_POST["surname"];
                                              $email = $_POST["email"];
                                              $phone = $_POST["phone"];
                                              $message = $_POST["message"];
                                              $attachment_name=$_FILES["attachment"]["name"];
                                            
                                            $query = "INSERT INTO `contactus` VALUES( '$selectoption', '$username', ' $surname', '$email ', '$phone','$message','$attachment_name')";
                                            $result=mysqli_query($conn,$query);
                                            if($result)
                                            {
                                            echo "Data Inserted into Database";
                                            }
                                            else{
                                            echo "Failed";
                                            }
                                          }
                                             
                                              ?>