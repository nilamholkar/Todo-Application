<?php
include 'connect.php';

$password = password_hash("admin123", PASSWORD_BCRYPT);
$sql = "INSERT INTO users (name, email, password, role) VALUES ('Admin', 'admin@example.com', '$password', 'admin')";

if ($conn->query($sql) === TRUE) {
    echo "Admin user created successfully!";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
