<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'];

// Fetch user name
$username_query = $conn->query("SELECT name FROM users WHERE id='$user_id'");
$username = $username_query->fetch_assoc()['name'];

// Fetch todos based on role
if ($user_role == 'admin') {
    $result = $conn->query("SELECT t.*, u.name AS assigned_to_name FROM todos t LEFT JOIN users u ON t.assigned_to = u.id ORDER BY t.created_at DESC");
} else {
    $result = $conn->query("SELECT * FROM todos WHERE assigned_to='$user_id' ORDER BY created_at DESC");
}

// Fetch employees list for assigning tasks
$employees = $conn->query("SELECT id, name FROM users WHERE role='employee'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-4xl mx-auto bg-white shadow-md rounded p-6">
        <h2 class="text-2xl font-bold mb-4">Welcome, <?= htmlspecialchars($username) ?></h2>

        <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded">Logout</a>

        <?php if ($user_role == 'admin'): ?>
            <h3 class="text-xl font-semibold mt-6">Create New To-Do</h3>
            <form action="create_todo.php" method="POST" class="mt-2">
                <input type="text" name="title" placeholder="Title" required class="border p-2 rounded w-full mb-2">
                <textarea name="description" placeholder="Description" class="border p-2 rounded w-full mb-2"></textarea>
                <select name="assigned_to" required class="border p-2 rounded w-full mb-2">
                    <option value="">Assign to Employee</option>
                    <?php while ($emp = $employees->fetch_assoc()): ?>
                        <option value="<?= $emp['id'] ?>"><?= $emp['name'] ?></option>
                    <?php endwhile; ?>
                </select>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Create To-Do</button>
            </form>
        <?php endif; ?>

        <h3 class="text-xl font-semibold mt-6">To-Do List<?php if ($user_role == 'admin'): ?><span class="text-right bg-blue-500 text-white px-4 py-2 rounded" style="float:right;"><a href="invite_employee.php">Add/Invite Employee</a></span> <?php endif; ?></h3>

        <div x-data="{ showDeleteModal: false, deleteId: null }">
            <table class="w-full border-collapse border border-gray-300 mt-4">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">Title</th>
                        <th class="border p-2">Description</th>
                        <th class="border p-2">Status</th>
                        <th class="border p-2">Assigned To</th>
                        <th class="border p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($todo = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="border p-2"><?= $todo['title'] ?></td>
                            <td class="border p-2"><?= $todo['description'] ?></td>
                            <td class="border p-2"><?= ucfirst($todo['status']) ?></td>
                            <td class="border p-2"><?= isset($todo['assigned_to_name']) ? $todo['assigned_to_name'] : 'N/A' ?></td>
                            
                            <td class="border p-2">
                                <?php if ($user_role == 'admin'): ?>
                                    <a href="edit_todo.php?id=<?= $todo['id'] ?>" class="bg-blue-500 text-white px-3 py-1 rounded">Edit</a>
                                    <button @click="showDeleteModal = true; deleteId = <?= $todo['id'] ?>" 
                                        class="bg-red-500 text-white px-4 py-2 rounded">
                                        Delete
                                    </button>
                                <?php endif; ?>

                                <?php if ($user_role == 'employee'): ?>
                                    <form action="update_todo.php" method="POST" class="inline">
                                        <input type="hidden" name="todo_id" value="<?= $todo['id'] ?>">
                                        <select name="status" class="border p-1">
                                            <option value="in_progress" <?= $todo['status'] == 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                                            <option value="completed" <?= $todo['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                                        </select>
                                        <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Update</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Delete Confirmation Modal -->
            <template x-if="showDeleteModal">
                <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-white p-6 rounded shadow-lg text-center">
                        <h2 class="text-lg font-semibold">Are you sure?</h2>
                        <p class="text-gray-600">You are about to delete this task.</p>
                        <div class="mt-4">
                            <a :href="'delete_todo.php?id=' + deleteId"
                                class="bg-red-500 text-white px-4 py-2 rounded">
                                Yes, Delete
                            </a>
                            <button @click="showDeleteModal = false" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

</body>
</html>
