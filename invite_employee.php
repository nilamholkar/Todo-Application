<?php
session_start();
include 'connect.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include PHPMailer via Composer

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
        $name = $_POST['name'];
        $email = $_POST['email'];
        // $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
        $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '', 'employee')";
        if ($conn->query($sql) === TRUE) {

    // Send invitation email via PHPMailer
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
        $mail->Subject = 'Invitation to Join the System';
        $mail->Body    = "Hello $name, <br><br>Please Click the link below to set your password and join the system:<br><br>" . 
                         "<a href='http://localhost/Todo-Application/set_password.php?email=$email'>Set Password</a><br><br>Thank You.";

        $mail->send();
        echo "Invitation sent to $email!";
    } catch (Exception $e) {
        echo "Failed to send invitation. Mailer Error: {$mail->ErrorInfo}";
    }
}
else
{
    echo "Invitation mail Address";
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invite Employee</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-md mx-auto bg-white shadow-md rounded p-6">
        <h2 class="text-2xl font-bold mb-4">Invite Employee</h2>

        <form method="POST">
        <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-2">Name</label>
        <input type="text" name="name" placeholder="Enter your name" required 
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
            <label for="email" class="block text-sm font-medium text-gray-700">Employee Email</label>
            <input type="email" name="email" id="email" class="border p-2 rounded w-full mb-4" required>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Send Invitation</button>
        </form>
    </div>

</body>
</html>
