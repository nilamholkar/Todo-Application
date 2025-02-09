<?php
session_start();
include 'connect.php';

// Check if the token is passed via the URL
if (isset($_GET['email'])) {
    $email = $_GET['email'];

    // Fetch the user associated with the token
    $result = $conn->query("SELECT * FROM users WHERE email='$email'");

    // If no user is found or the token is expired
    if ($result->num_rows === 0) {
        echo "Invalid or email id.";
        exit;
    }

    // If the token is valid, proceed to password reset
    $user = $result->fetch_assoc();

    // Handle the password update when the form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $password = $_POST['password'];

        // Hash the password before saving it to the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Update the password in the database and clear the token
        $conn->query("UPDATE users SET password='$hashed_password' WHERE email='$email'");

        echo "Your password has been set successfully. You can now <a href='index.php'>login</a>.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-md mx-auto bg-white shadow-md rounded p-6">
        <h2 class="text-2xl font-bold mb-4">Set Your Password</h2>

        <!-- Password Set Form -->
        <form method="POST">
            <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
            <input type="password" name="password" id="password" class="border p-2 rounded w-full mb-4" required>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Set Password</button>
        </form>
    </div>

</body>
</html>
