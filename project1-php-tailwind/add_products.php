<?php
session_start();
require_once "config/db.php";

$categories = $conn->query("SELECT * FROM categories");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $cat = $_POST['category'];
    $qty = $_POST['qty'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("
        INSERT INTO products (product_name, category_id, quantity, price)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param("siid", $name, $cat, $qty, $price);
    $stmt->execute();

    header("Location: products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-blue-100 min-h-screen flex">

<!-- SIDEBAR -->
<div class="w-64 bg-gradient-to-b from-blue-700 to-blue-500 text-white p-6 flex flex-col justify-between">
    <div>
        <h1 class="text-2xl font-bold mb-10">Inventory System</h1>

        <nav class="space-y-4">
            <a href="dashboard.php" class="block px-4 py-2 rounded-lg hover:bg-blue-600">Dashboard</a>
            <a href="products.php" class="block px-4 py-2 rounded-lg bg-blue-800">Products</a>
            <a href="categories.php" class="block px-4 py-2 rounded-lg hover:bg-blue-600">Categories</a>
        </nav>
    </div>

    <div>
        <a href="products.php" class="block px-4 py-2 rounded-lg hover:bg-blue-600 mb-2">← Back</a>
        <a href="auth/logout.php" class="block px-4 py-2 rounded-lg hover:bg-red-500">Logout</a>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="flex-1 p-10">

    <h2 class="text-3xl font-bold text-gray-800 mb-6">Add Product</h2>

    <div class="bg-white p-6 rounded-xl shadow-md max-w-xl">

        <form method="POST" class="space-y-5">

            <!-- Product Name -->
            <div>
                <label class="block text-gray-600 mb-1">Product Name</label>
                <input 
                    name="name"
                    placeholder="Enter product name..."
                    required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Category -->
            <div>
                <label class="block text-gray-600 mb-1">Category</label>
                <select 
                    name="category"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php while($c = $categories->fetch_assoc()): ?>
                        <option value="<?= $c['id'] ?>">
                            <?= htmlspecialchars($c['category_name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Quantity -->
            <div>
                <label class="block text-gray-600 mb-1">Quantity</label>
                <input 
                    type="number"
                    name="qty"
                    placeholder="Enter quantity"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Price -->
            <div>
                <label class="block text-gray-600 mb-1">Price</label>
                <input 
                    type="number"
                    step="0.01"
                    name="price"
                    placeholder="Enter price"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Buttons -->
            <div class="flex gap-3">
                <button 
                    type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                    Add Product
                </button>

                <a href="products.php"
                   class="px-5 py-2 rounded-lg border hover:bg-gray-100">
                   Cancel
                </a>
            </div>

        </form>
    </div>

</div>
</body>
</html>
