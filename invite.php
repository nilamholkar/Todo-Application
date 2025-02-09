<?php
session_start();
include 'connect.php';

if ($_SESSION['role'] !== 'admin') die("Access denied");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(16));

    $subject = "Invitation to Join";
    $message = "Click here to join: http://localhost/register.php?email=$email";
    $headers = "From: admin@example.com";

    if (mail($email, $subject, $message, $headers)) {
        echo "<script>alert('Invitation Sent!');</script>";
    } else {
        echo "<script>alert('Failed to send email');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <script src="https://unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 p-6">
<form method="POST" class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-4 text-center text-gray-800">Invite Employee</h2>

    <!-- Email Input -->
    <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-2">Employee Email</label>
        <input type="email" name="email" placeholder="Enter employee email" required 
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
    </div>

    <!-- Submit Button -->
    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-300">
        Send Invitation
    </button>
</form>
</body>
</html>
