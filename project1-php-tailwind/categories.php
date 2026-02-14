<?php
session_start();
require_once "config/db.php";

// DELETE
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM categories WHERE id=$id");
    header("Location: categories.php");
    exit();
}

$result = $conn->query("SELECT * FROM categories ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Categories</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-blue-100 min-h-screen flex">

<!-- SIDEBAR -->
<div class="w-64 bg-gradient-to-b from-blue-700 to-blue-500 text-white p-6 flex flex-col justify-between">
    <div>
        <h1 class="text-2xl font-bold mb-10">Inventory System</h1>

        <nav class="space-y-4">
            <a href="dashboard.php" class="block px-4 py-2 rounded-lg hover:bg-blue-600">Dashboard</a>
            <a href="products.php" class="block px-4 py-2 rounded-lg hover:bg-blue-600">Products</a>
            <a href="categories.php" class="block px-4 py-2 rounded-lg bg-blue-800">Categories</a>
        </nav>
    </div>

    <div>
        <a href="add_categories.php" class="block px-4 py-2 rounded-lg hover:bg-blue-600 mb-2">+ Add Category</a>
        <a href="auth/logout.php" class="block px-4 py-2 rounded-lg hover:bg-red-500">Logout</a>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="flex-1 p-10">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Categories</h2>

        <a href="add_categories.php"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
           + Add Category
        </a>
    </div>

    <!-- TABLE CARD -->
    <div class="bg-white p-6 rounded-xl shadow-md">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b text-gray-600">
                    <th class="py-3">ID</th>
                    <th>Name</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>

            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr class="border-b hover:bg-blue-50">
                    <td class="py-3"><?= $row['id'] ?></td>

                    <td><?= htmlspecialchars($row['category_name']) ?></td>

                    <td class="text-right space-x-3">
                        <a href="edit_categories.php?id=<?= $row['id'] ?>"
                           class="text-blue-600 hover:underline font-medium">
                           Edit
                        </a>

                        <a href="?delete=<?= $row['id'] ?>"
                           onclick="return confirm('Delete this category?')"
                           class="text-red-500 hover:underline font-medium">
                           Delete
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>
</body>
</html>
