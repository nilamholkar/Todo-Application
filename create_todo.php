<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include PHPMailer via Composer
include 'connect.php';

if ($_SESSION['role'] !== 'admin') die("Access denied");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $assigned_to = $_POST['assigned_to'];
    $created_by = $_SESSION['user_id'];


    $sql = "INSERT INTO todos (title, description, assigned_to, created_by) VALUES ('$title', '$desc', '$assigned_to', '$created_by')";

    if ($conn->query($sql) === TRUE) {
        $result = $conn->query("SELECT name,email FROM users WHERE id='$assigned_to'");
        $email = $result->fetch_assoc()['email'];
        $name = $result->fetch_assoc()['name'];
        
        
        $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'nilamholkar14@gmail.com';  // Your Gmail address
        $mail->Password = 'vbxn vtrq nghr tsmc';  // Your Gmail password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('nilamholkar14@gmail.com', 'Admin');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Task Assigned';
        $mail->Body    = "Hello $name,<br><br>A new task $title has been assigned to you.<br><br>Thank you.";

        $mail->send();
        echo "<script>alert('To-Do Created and Employee Notified!'); window.location.href='dashboard.php';</script>";
        // echo "Notification sent to $email!";
    } catch (Exception $e) {
        echo "Failed to send notification. Mailer Error: {$mail->ErrorInfo}";
    }

        // $subject = "New Task Assigned";
        // $message = "A new task '$title' has been assigned to you.";
        // $headers = "From: admin@example.com";

        // mail($employee['email'], $subject, $message, $headers);

       
    }
}
?>
