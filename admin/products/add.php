<?php
require_once '../../includes/config.php'; // Added: ensures $conn is set if needed
require_once '../../includes/auth.php';

require_admin_login();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add New Product</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <?php include '../includes/admin-header.php'; ?>
    
    <div class="admin-container">
        <?php include '../includes/sidebar.php'; ?>
        
        <main class="admin-content">
            <h1>Add New Product</h1>
            
            <form action="save_product.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" name="name" required>
                </div>
                
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="5" required></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Price ($)</label>
                        <input type="number" name="price" step="0.01" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Stock Quantity</label>
                        <input type="number" name="stock" min="0" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" required>
                        <option value="">Select Category</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Fashion">Fashion</option>
                        <option value="Home & Kitchen">Home & Kitchen</option>
                        <option value="Beauty">Beauty</option>
                        <option value="Sports">Sports</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Product Image</label>
                    <input type="file" name="image" accept="image/*" required>
                </div>
                
                <button type="submit" class="btn-primary">Save Product</button>
            </form>
        </main>
    </div>
</body>
</html>