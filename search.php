<?php
$pageTitle = "Search Results";
require_once 'includes/header.php';
require_once 'includes/config.php';

if (!isset($_GET['query']) || empty(trim($_GET['query']))) {
    header("Location: index.php");
    exit();
}

$search_query = '%' . trim($_GET['query']) . '%';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 12;
$offset = ($page - 1) * $limit;

// Get search results
$sql = "SELECT * FROM products 
        WHERE name LIKE ? OR description LIKE ? 
        LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssii", $search_query, $search_query, $limit, $offset);
$stmt->execute();
$results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get total count for pagination
$count_sql = "SELECT COUNT(*) as total FROM products 
              WHERE name LIKE ? OR description LIKE ?";
$count_stmt = $conn->prepare($count_sql);
$count_stmt->bind_param("ss", $search_query, $search_query);
$count_stmt->execute();
$total_count = $count_stmt->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_count / $limit);
?>

<section class="search-results">
    <h1>Search Results for "<?= htmlspecialchars(trim($_GET['query'])) ?>"</h1>
    
    <?php if (count($results) > 0) : ?>
        <p class="results-count"><?= $total_count ?> results found</p>
        
        <div class="product-grid">
            <?php foreach ($results as $product) : ?>
            <div class="product-card fade-in">
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
            <?php endforeach; ?>
        </div>
        
        <?php if ($total_pages > 1) : ?>
        <div class="pagination">
            <?php if ($page > 1) : ?>
                <a href="search.php?query=<?= urlencode($_GET['query']) ?>&page=<?= $page - 1 ?>" class="page-link">
                    <i class="fas fa-chevron-left"></i> Prev
                </a>
            <?php endif; ?>
            
            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <a href="search.php?query=<?= urlencode($_GET['query']) ?>&page=<?= $i ?>" 
                   class="page-link <?= $i === $page ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
            
            <?php if ($page < $total_pages) : ?>
                <a href="search.php?query=<?= urlencode($_GET['query']) ?>&page=<?= $page + 1 ?>" class="page-link">
                    Next <i class="fas fa-chevron-right"></i>
                </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
    <?php else : ?>
        <div class="no-results">
            <i class="fas fa-search"></i>
            <h3>No products found</h3>
            <p>Try different keywords or browse our categories</p>
            <a href="index.php" class="btn-primary">Browse All Products</a>
        </div>
    <?php endif; ?>
</section>

<?php require_once 'includes/footer.php'; ?>