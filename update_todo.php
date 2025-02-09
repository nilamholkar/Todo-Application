<?php
session_start();
include 'connect.php';

if ($_SESSION['role'] !== 'employee') die("Access denied");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $todo_id = $_POST['todo_id'];
    $status = $_POST['status'];

    $sql = "UPDATE todos SET status='$status' WHERE id='$todo_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Status Updated!'); window.location.href='dashboard.php';</script>";
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
<form method="POST" class="flex items-center space-x-3">
    <input type="hidden" name="todo_id" value="1">

    <select name="status" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="in_progress">In Progress</option>
        <option value="completed">Completed</option>
    </select>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
        Update
    </button>
</form>
</body>
</html>
