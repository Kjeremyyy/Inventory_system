<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

require_once "config/db.php";

// Total Products
$totalProducts = $conn->query("SELECT COUNT(*) as total FROM products");
$totalProducts = $totalProducts->fetch_assoc()['total'];

// Total Categories
$totalCategories = $conn->query("SELECT COUNT(*) as total FROM categories");
$totalCategories = $totalCategories->fetch_assoc()['total'];

// Low Stock (example: quantity <= 5)
$lowStock = $conn->query("SELECT COUNT(*) as total FROM products WHERE quantity <= 5");
$lowStock = $lowStock->fetch_assoc()['total'];

$totalUsers = $conn->query("SELECT COUNT(*) as total FROM users");
$totalUsers = $totalUsers->fetch_assoc()['total'];



// Recent Products (latest 5)
$recentProducts = $conn->query("
    SELECT products.*, categories.category_name 
    FROM products
    LEFT JOIN categories ON products.category_id = categories.id
    ORDER BY products.id DESC
    LIMIT 5
");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-blue-100 min-h-screen flex">

<!-- SIDEBAR -->
<div class="w-64 bg-gradient-to-b from-blue-700 to-blue-500 text-white p-6 flex flex-col justify-between">

    <div>
        <h1 class="text-2xl font-bold mb-10">Inventory System</h1>

        <nav class="space-y-4">
            <a href="#" class="block px-4 py-2 rounded-lg bg-blue-800">Home</a>
            <a href="products.php" class="block px-4 py-2 rounded-lg hover:bg-blue-600">Products</a>
            <a href="categories.php" class="block px-4 py-2 rounded-lg hover:bg-blue-600">Categories</a>
        </nav>
    </div>

    <div>
        <a href="add_products.php" class="block px-4 py-2 rounded-lg hover:bg-blue-600 mb-2">+ Add Product</a>
        <a href="auth/logout.php" class="block px-4 py-2 rounded-lg hover:bg-red-500">Logout</a>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="flex-1 p-10">

    <!-- TOP BAR -->
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Dashboard</h2>

        <div class="flex items-center gap-4">
            <input type="text" placeholder="Search..."
                class="px-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-blue-500">

            <span class="text-gray-600">
                👋 <?php echo $_SESSION['user_name']; ?>
            </span>
        </div>
    </div>

    <!-- STAT CARDS -->
    <div class="grid grid-cols-4 gap-6 mb-10">

        <div class="bg-white p-6 rounded-xl shadow-md">
            <h3 class="text-3xl font-bold text-blue-600">
            <?php echo $totalProducts; ?>
            </h3>
            <p class="text-gray-500">New Items</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md">
            <h3 class="text-3xl font-bold text-blue-600">
            <?php echo $lowStock; ?>
              </h3>

            <p class="text-gray-500">Low Stock</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md">
            <h3 class="text-3xl font-bold text-blue-600">
            <?php echo $totalCategories; ?>
            </h3>

            <p class="text-gray-500">Categories</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md">
            <h3 class="text-3xl font-bold text-blue-600">
            <?php echo $totalUsers; ?>
            </h3>
            <p class="text-gray-500">Users</p>
        </div>

    </div>

   
    <div class="bg-white p-6 rounded-xl shadow-md">
        <h3 class="text-xl font-bold mb-4">Recent Products</h3>

        <table class="w-full text-left">
            <thead>
<tr class="border-b text-gray-600">
    <th class="py-2">Product</th>
    <th>Category</th>
    <th>Stock</th>
    <th>Price</th>
</tr>
</thead>

           <tbody>
        <?php while ($row = $recentProducts->fetch_assoc()) : ?>
            <tr class="border-b hover:bg-blue-50">
                <td class="py-2"><?php echo htmlspecialchars($row['product_name']); ?></td>
                <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                <td>
                    <?php if ($row['quantity'] <= 5) : ?>
                        <span class="text-red-600 font-semibold">
                            <?php echo $row['quantity']; ?> (Low)
                        </span>
                    <?php else : ?>
                        <?php echo $row['quantity']; ?>
                    <?php endif; ?>
                </td>
                <td>₱<?php echo number_format($row['price'], 2); ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>

        </table>
    </div>

</div>

</body>
</html>
