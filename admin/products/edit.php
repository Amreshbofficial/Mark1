<?php
require_once '../../includes/config.php'; // Added: ensures $conn is set
require_once '../../includes/auth.php';
require_admin_login();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: list.php");
    exit();
}

$product_id = intval($_GET['id']);
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result ? $result->fetch_assoc() : null;

if (!$product) {
    header("Location: list.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <?php include '../includes/admin-header.php'; ?>
    
    <div class="admin-container">
        <?php include '../includes/sidebar.php'; ?>
        
        <main class="admin-content">
            <h1>Edit Product</h1>
            
            <form action="update_product.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= (int)$product['id'] ?>">
                
                <div class="current-image">
                    <img src="/assets/images/products/<?= htmlspecialchars($product['image']) ?>" alt="Current Image">
                    <p>Current Image</p>
                </div>
                
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="5" required><?= htmlspecialchars($product['description']) ?></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Price ($)</label>
                        <input type="number" name="price" step="0.01" min="0" value="<?= htmlspecialchars($product['price']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Stock Quantity</label>
                        <input type="number" name="stock" min="0" value="<?= (int)$product['stock'] ?>" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" required>
                        <option value="Electronics" <?= $product['category'] == 'Electronics' ? 'selected' : '' ?>>Electronics</option>
                        <option value="Fashion" <?= $product['category'] == 'Fashion' ? 'selected' : '' ?>>Fashion</option>
                        <option value="Home & Kitchen" <?= $product['category'] == 'Home & Kitchen' ? 'selected' : '' ?>>Home & Kitchen</option>
                        <option value="Beauty" <?= $product['category'] == 'Beauty' ? 'selected' : '' ?>>Beauty</option>
                        <option value="Sports" <?= $product['category'] == 'Sports' ? 'selected' : '' ?>>Sports</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>New Product Image (Leave blank to keep current)</label>
                    <input type="file" name="image" accept="image/*">
                </div>
                
                <button type="submit" class="btn-primary">Update Product</button>
                <a href="list.php" class="btn-outline">Cancel</a>
            </form>
        </main>
    </div>
</body>
</html>