<?php
$pageTitle = "Home";
// Load configuration and header
require_once 'includes/config.php';
require_once 'includes/header.php';

// Verify database connection exists
if (!isset($conn) || !$conn) {
    die("Database connection error. Please check your configuration.");
}

// Load product functions
require_once 'product_functions.php';
?>

<!-- Remove <main> here if it is already present in header.php -->
<main>
    <section class="hero">
        <div class="hero-content">
            <h1>Welcome to Brand Bazaar</h1>
            <p>Discover amazing products at unbeatable prices</p>
            <a href="#featured-products" class="btn-primary">Shop Now</a>
        </div>
    </section>
    
    <section id="featured-products" class="product-section">
        <h2>Featured Products</h2>
        <div class="product-grid">
            <?php
            try {
                $products = get_featured_products($conn);
                
                if (empty($products)) {
                    echo "<p class='no-products'>No featured products found. Please check back later.</p>";
                } else {
                    foreach ($products as $product) :
                        // Validate image path safely for web and file system
                        $image = isset($product['image']) ? $product['image'] : '';
                        $imageName = basename($image);
                        $relativeImagePath = "assets/images/products/" . $imageName;
                        $absoluteImagePath = $_SERVER['DOCUMENT_ROOT'] . "/assets/images/products/" . $imageName;
                        $defaultImage = "assets/images/placeholder.jpg";
                        $finalImage = (is_file($absoluteImagePath)) ? $relativeImagePath : $defaultImage;

                        $productName = isset($product['name']) ? htmlspecialchars($product['name']) : 'Unnamed Product';
                        $productPrice = isset($product['price']) ? number_format($product['price'], 2) : '0.00';
                        $productId = isset($product['id']) ? (int)$product['id'] : 0;
            ?>
            <div class="product-card fade-in">
                <div class="product-image">
                    <img src="<?= htmlspecialchars($finalImage) ?>" alt="<?= $productName ?>">
                    <div class="quick-actions">
                        <button class="wishlist-btn" data-id="<?= $productId ?>">
                            <i class="far fa-heart"></i>
                        </button>
                        <button class="cart-btn" data-id="<?= $productId ?>">
                            <i class="fas fa-shopping-cart"></i>
                        </button>
                    </div>
                </div>
                <div class="product-info">
                    <h3><?= $productName ?></h3>
                    <p class="price">$<?= $productPrice ?></p>
                    <a href="product.php?id=<?= $productId ?>" class="btn-primary">View Details</a>
                </div>
            </div>
            <?php 
                    endforeach;
                }
            } catch (Exception $e) {
                echo "<p class='error'>Error loading products: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
            ?>
        </div>
    </section>
    
    <section class="features">
        <div class="feature-card">
            <i class="fas fa-shipping-fast"></i>
            <h3>Free Shipping</h3>
            <p>On orders over $50</p>
        </div>
        <div class="feature-card">
            <i class="fas fa-undo-alt"></i>
            <h3>Easy Returns</h3>
            <p>30-day return policy</p>
        </div>
        <div class="feature-card">
            <i class="fas fa-shield-alt"></i>
            <h3>Secure Payments</h3>
            <p>100% secure transactions</p>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>