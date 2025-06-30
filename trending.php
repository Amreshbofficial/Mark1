<?php
$pageTitle = "Trending Products";
require_once 'includes/config.php';
require_once 'includes/header.php';
?>

<section class="trending-section">
    <h1>Trending Products</h1>
    
    <div class="category-filters">
        <button class="filter-btn active" data-category="all">All</button>
        <button class="filter-btn" data-category="Electronics">Electronics</button>
        <button class="filter-btn" data-category="Fashion">Fashion</button>
        <button class="filter-btn" data-category="Home & Kitchen">Home & Kitchen</button>
    </div>
    
    <div class="product-grid">
        <?php
        $sql = "SELECT * FROM products ORDER BY created_at DESC LIMIT 12";
        $result = $conn->query($sql);
        
        while ($product = $result->fetch_assoc()) : 
        ?>
        <div class="product-card fade-in" data-category="<?= $product['category'] ?>">
            <div class="product-image">
                <img src="/assets/images/products/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                <div class="quick-actions">
                    <button class="wishlist-btn" data-id="<?= $product['id'] ?>">
                        <i class="far fa-heart"></i>
                    </button>
                    <button class="cart-btn" data-id="<?= $product['id'] ?>">
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                </div>
            </div>
            <div class="product-info">
                <h3><?= $product['name'] ?></h3>
                <p class="price">$<?= number_format($product['price'], 2) ?></p>
                <a href="product.php?id=<?= $product['id'] ?>" class="btn-primary">View Details</a>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<script>
// Category filtering
document.querySelectorAll('.filter-btn').forEach(button => {
    button.addEventListener('click', function() {
        // Update active button
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        this.classList.add('active');
        
        // Filter products
        const category = this.dataset.category;
        document.querySelectorAll('.product-card').forEach(card => {
            if (category === 'all' || card.dataset.category === category) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>