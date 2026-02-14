<?php
session_start();
require_once "config/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];

    $stmt = $conn->prepare("INSERT INTO categories (category_name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();

    header("Location: categories.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Category</title>
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
        <a href="categories.php" class="block px-4 py-2 rounded-lg hover:bg-blue-600 mb-2">← Back</a>
        <a href="auth/logout.php" class="block px-4 py-2 rounded-lg hover:bg-red-500">Logout</a>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="flex-1 p-10">

    <h2 class="text-3xl font-bold text-gray-800 mb-6">Add Category</h2>

    <div class="bg-white p-6 rounded-xl shadow-md max-w-lg">

        <form method="POST" class="space-y-5">

            <div>
                <label class="block text-gray-600 mb-1">Category Name</label>
                <input 
                    type="text" 
                    name="name" 
                    placeholder="Enter category name..."
                    required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div class="flex gap-3">
                <button 
                    type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                    Add Category
                </button>

                <a href="categories.php"
                   class="px-5 py-2 rounded-lg border hover:bg-gray-100">
                   Cancel
                </a>
            </div>

        </form>

    </div>
</div>

</body>
</html>
