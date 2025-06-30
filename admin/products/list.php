<?php
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_admin_login();
require_once '../../includes/admin_functions.php'; // if your get_all_products() is here
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <?php include '../includes/admin-header.php'; ?>
    
    <div class="admin-container">
        <?php include '../includes/sidebar.php'; ?>
        
        <main class="admin-content">
            <div class="content-header">
                <h1>Manage Products</h1>
                <a href="add.php" class="btn-primary">Add New Product</a>
            </div>
            
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $products = get_all_products($conn);
                        if ($products) :
                        foreach ($products as $product) :
                        ?>
                        <tr>
                            <td><?= (int)$product['id'] ?></td>
                            <td>
                                <img src="/assets/images/products/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-thumb">
                            </td>
                            <td><?= htmlspecialchars($product['name']) ?></td>
                            <td><?= htmlspecialchars($product['category']) ?></td>
                            <td>$<?= number_format($product['price'], 2) ?></td>
                            <td><?= (int)$product['stock'] ?></td>
                            <td class="actions">
                                <a href="edit.php?id=<?= (int)$product['id'] ?>" class="btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="delete.php" method="POST" class="delete-form" onsubmit="return confirm('Delete this product?');">
                                    <input type="hidden" name="id" value="<?= (int)$product['id'] ?>">
                                    <button type="submit" class="btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="7">No products found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    
    <script src="/assets/js/admin.js"></script>
</body>
</html>