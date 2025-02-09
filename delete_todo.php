<?php
session_start();
include 'connect.php';

if ($_SESSION['role'] !== 'admin') die("Access denied");

if (isset($_GET['id'])) {
    $todo_id = $_GET['id'];
    $conn->query("DELETE FROM todos WHERE id='$todo_id'");
    echo "<script>alert('To-Do Deleted!'); window.location.href='dashboard.php';</script>";
}
?>
