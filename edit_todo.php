<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

// Get the To-Do ID from the URL
$todo_id = $_GET['id'] ?? null;
if (!$todo_id) {
    echo "Invalid request!";
    exit;
}

// Fetch the existing To-Do details
$todo_query = $conn->query("SELECT * FROM todos WHERE id='$todo_id'");
$todo = $todo_query->fetch_assoc();

if (!$todo) {
    echo "To-Do not found!";
    exit;
}

// Fetch employees for assigning tasks
$employees = $conn->query("SELECT id, name FROM users WHERE role='employee'");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $assigned_to = $_POST['assigned_to'];
    $status = $_POST['status'];

    $conn->query("UPDATE todos SET 
        title='$title', 
        description='$description', 
        assigned_to='$assigned_to', 
        status='$status' 
        WHERE id='$todo_id'");

    // Redirect after update
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit To-Do</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-2xl mx-auto bg-white shadow-md rounded p-6">
        <h2 class="text-2xl font-bold mb-4">Edit To-Do</h2>

        <form method="POST">
            <label class="block font-medium">Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($todo['title']) ?>" required class="border p-2 rounded w-full mb-2">

            <label class="block font-medium">Description</label>
            <textarea name="description" class="border p-2 rounded w-full mb-2"><?= htmlspecialchars($todo['description']) ?></textarea>

            <label class="block font-medium">Assign to Employee</label>
            <select name="assigned_to" class="border p-2 rounded w-full mb-2">
                <?php while ($emp = $employees->fetch_assoc()): ?>
                    <option value="<?= $emp['id'] ?>" <?= $emp['id'] == $todo['assigned_to'] ? 'selected' : '' ?>>
                        <?= $emp['name'] ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label class="block font-medium">Status</label>
            <select name="status" class="border p-2 rounded w-full mb-4">
                <option value="open" <?= $todo['status'] == 'open' ? 'selected' : '' ?>>Open</option>
                <option value="in_progress" <?= $todo['status'] == 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                <option value="completed" <?= $todo['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
            </select>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update</button>
            <a href="dashboard.php" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Cancel</a>
        </form>
    </div>

</body>
</html>
