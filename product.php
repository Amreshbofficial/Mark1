<?php
$pageTitle = "Product Details";
require_once 'includes/header.php';
require_once 'includes/config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$product_id = intval($_GET['id']);
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "<div class='alert alert-danger'>Product not found</div>";
    include 'includes/footer.php';
    exit();
}
?>

<section class="product-detail">
    <div class="product-images">
        <div class="main-image">
            <img src="/assets/images/products/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
        </div>
    </div>
    
    <div class="product-info">
        <h1><?= $product['name'] ?></h1>
        <div class="price">$<?= number_format($product['price'], 2) ?></div>
        
        <div class="product-meta">
            <div><span>Category:</span> <?= $product['category'] ?></div>
            <div><span>Availability:</span> 
                <?= $product['stock'] > 0 ? 
                    '<span class="in-stock">In Stock</span>' : 
                    '<span class="out-of-stock">Out of Stock</span>' ?>
            </div>
        </div>
        
        <p class="description"><?= $product['description'] ?></p>
        
        <div class="product-actions">
            <div class="quantity-selector">
                <button class="quantity-btn minus">-</button>
                <input type="number" id="quantity" value="1" min="1" max="<?= $product['stock'] ?>">
                <button class="quantity-btn plus">+</button>
            </div>
            
            <button class="btn-primary add-to-cart" data-id="<?= $product['id'] ?>">
                <i class="fas fa-shopping-cart"></i> Add to Cart
            </button>
            
            <button class="btn-outline add-to-wishlist" data-id="<?= $product['id'] ?>">
                <i class="far fa-heart"></i> Add to Wishlist
            </button>
        </div>
    </div>
</section>

<section class="related-products">
    <h2>Related Products</h2>
    <div class="product-grid">
        <?php
        $sql = "SELECT * FROM products WHERE category = ? AND id != ? LIMIT 4";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $product['category'], $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($related = $result->fetch_assoc()) : ?>
        <div class="product-card">
            <div class="product-image">
                <img src="/assets/images/products/<?= $related['image'] ?>" alt="<?= $related['name'] ?>">
            </div>
            <div class="product-info">
                <h3><?= $related['name'] ?></h3>
                <p class="price">$<?= number_format($related['price'], 2) ?></p>
                <a href="product.php?id=<?= $related['id'] ?>" class="btn-primary">View Details</a>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>