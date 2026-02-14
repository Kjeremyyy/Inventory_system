<?php
require_once "config/db.php";

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM categories WHERE id=$id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $stmt = $conn->prepare("UPDATE categories SET category_name=? WHERE id=?");
    $stmt->bind_param("si", $name, $id);
    $stmt->execute();
    header("Location: categories.php");
}
?>

<form method="POST">
    <input type="text" name="name" value="<?= $data['category_name'] ?>">
    <button>Update</button>
</form>
