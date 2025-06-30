<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brand Bazaar - <?= $pageTitle ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <div class="top-bar">
            <div class="logo">
                <a href="/index.php">BrandBazaar</a>
            </div>
            
            <div class="search-bar">
                <form action="/search.php" method="GET">
                    <input type="text" name="query" placeholder="Search products..." value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '' ?>">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            
            <div class="user-actions">
                <a href="/wishlist.php" class="action-icon">
                    <i class="fas fa-heart"></i>
                    <span class="count-badge wishlist-count">0</span>
                </a>
                <a href="/cart.php" class="action-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="count-badge cart-count">0</span>
                </a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="user-dropdown">
                        <button class="user-btn">
                            <i class="fas fa-user-circle"></i>
                            <span><?= $_SESSION['user_name'] ?></span>
                        </button>
                        <div class="dropdown-content">
                            <a href="/profile.php"><i class="fas fa-user"></i> My Profile</a>
                            <a href="/myorders.php"><i class="fas fa-shopping-bag"></i> My Orders</a>
                            <a href="/wishlist.php"><i class="fas fa-heart"></i> Wishlist</a>
                            <a href="/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="/signin.php" class="btn-outline">Sign In</a>
                <?php endif; ?>
            </div>
        </div>
        
        <nav>
    <ul>
        <li><a href="/index.php">Home</a></li>
        <li><a href="/trending.php">Trending</a></li>
        <li class="dropdown">
            <a href="#">Categories <i class="fas fa-chevron-down"></i></a>
            <ul class="dropdown-menu">
                <li><a href="#">Electronics</a></li>
                <li><a href="#">Fashion</a></li>
                <li><a href="#">Home & Kitchen</a></li>
                <li><a href="#">Beauty</a></li>
                <li><a href="#">Sports</a></li>
            </ul>
        </li>
        <li><a href="/contact.php">Contact</a></li>
        <li><a href="/myorders.php">My Orders</a></li>
    </ul>
</nav>
    </header>
    
    <div class="mobile-nav">
        <button class="menu-toggle"><i class="fas fa-bars"></i></button>
        <a href="/index.php" class="mobile-logo">BrandBazaar</a>
        <div class="mobile-cart">
            <a href="/cart.php"><i class="fas fa-shopping-cart"></i></a>
        </div>
    </div>
    
    <div class="mobile-menu">
        <ul>
            <li><a href="/index.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="/trending.php"><i class="fas fa-fire"></i> Trending</a></li>
            <li><a href="#"><i class="fas fa-list"></i> Categories</a></li>
            <li><a href="/contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
            <li><a href="/myorders.php"><i class="fas fa-shopping-bag"></i> My Orders</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="/profile.php"><i class="fas fa-user"></i> Profile</a></li>
                <li><a href="/wishlist.php"><i class="fas fa-heart"></i> Wishlist</a></li>
                <li><a href="/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            <?php else: ?>
                <li><a href="/signin.php"><i class="fas fa-sign-in-alt"></i> Sign In</a></li>
                <li><a href="/signup.php"><i class="fas fa-user-plus"></i> Sign Up</a></li>
            <?php endif; ?>
        </ul>
    </div>
    
    <main>