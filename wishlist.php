<?php
$pageTitle = "Wishlist";
require_once 'includes/config.php';
require_once 'includes/header.php';
require_login();

$user_id = $_SESSION['user_id'];
$sql = "SELECT w.*, p.name, p.price, p.image 
        FROM wishlist w 
        JOIN products p ON w.product_id = p.id 
        WHERE w.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$wishlist_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<section class="wishlist-section">
    <h1>Your Wishlist</h1>
    <?php if (count($wishlist_items) === 0) : ?>
        <div class="empty-wishlist">
            <i class="fas fa-heart"></i>
            <h3>Your wishlist is empty</h3>
            <p>Add items to your wishlist to save them for later</p>
            <a href="index.php" class="btn-primary">Browse Products</a>
        </div>
    <?php else : ?>
        <div class="wishlist-grid">
            <?php foreach ($wishlist_items as $item) : ?>
            <div class="wishlist-item">
                <div class="product-image">
                    <img src="/assets/images/products/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                </div>
                <div class="product-info">
                    <h3><?= htmlspecialchars($item['name']) ?></h3>
                    <p class="price">$<?= number_format($item['price'], 2) ?></p>
                    <div class="item-actions">
                        <button class="btn-primary add-to-cart" data-id="<?= (int)$item['product_id'] ?>">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                        <button class="btn-outline remove-wishlist" data-id="<?= (int)$item['id'] ?>">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php require_once 'includes/footer.php'; ?>