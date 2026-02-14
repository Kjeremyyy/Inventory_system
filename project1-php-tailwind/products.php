<?php
session_start();
require_once "config/db.php";

// DELETE
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM products WHERE id=$id");
    header("Location: products.php");
    exit();
}

$search = $_GET['search'] ?? '';

$sql = "
    SELECT products.*, categories.category_name
    FROM products
    LEFT JOIN categories ON products.category_id = categories.id
";

if ($search) {
    $search = $conn->real_escape_string($search);
    $sql .= " WHERE product_name LIKE '%$search%'";
}

$sql .= " ORDER BY products.id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-blue-100 min-h-screen flex">

<!-- SIDEBAR -->
<div class="w-64 bg-gradient-to-b from-blue-700 to-blue-500 text-white p-6 flex flex-col justify-between">
    <div>
        <h1 class="text-2xl font-bold mb-10">Inventory System</h1>

        <nav class="space-y-4">
            <a href="dashboard.php" class="block px-4 py-2 rounded-lg hover:bg-blue-600">Dashboard</a>
            <a href="#" class="block px-4 py-2 rounded-lg bg-blue-800">Products</a>
            <a href="categories.php" class="block px-4 py-2 rounded-lg hover:bg-blue-600">Categories</a>
        </nav>
    </div>

    <a href="auth/logout.php" class="block px-4 py-2 rounded-lg hover:bg-red-500">Logout</a>
</div>

<!-- MAIN -->
<div class="flex-1 p-10">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Products</h2>

        <a href="add_products.php"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
           + Add Product
        </a>
    </div>

    <!-- SEARCH -->
    <form method="GET" class="mb-6">
        <input name="search"
            placeholder="Search product..."
            value="<?= htmlspecialchars($search) ?>"
            class="px-4 py-2 rounded-lg border w-80 focus:ring-2 focus:ring-blue-500 outline-none">
    </form>

    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="p-4">Product</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr class="border-t hover:bg-blue-50 transition">
                    <td class="p-4 font-semibold">
                        <?= htmlspecialchars($row['product_name']) ?>
                    </td>

                    <td><?= htmlspecialchars($row['category_name']) ?></td>

                    <td>
                        <?php if ($row['quantity'] <= 5): ?>
                            <span class="text-red-600 font-bold">
                                <?= $row['quantity'] ?> (Low)
                            </span>
                        <?php else: ?>
                            <span class="text-green-600 font-semibold">
                                <?= $row['quantity'] ?>
                            </span>
                        <?php endif; ?>
                    </td>

                    <td class="font-medium text-gray-700">
                        ₱<?= number_format($row['price'], 2) ?>
                    </td>

                    <td class="text-center space-x-2">
                        <a href="edit_products.php?id=<?= $row['id'] ?>"
                           class="bg-yellow-400 px-3 py-1 rounded text-white hover:bg-yellow-500">
                           Edit
                        </a>

                        <a href="?delete=<?= $row['id'] ?>"
                           onclick="return confirm('Delete this product?')"
                           class="bg-red-500 px-3 py-1 rounded text-white hover:bg-red-600">
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
