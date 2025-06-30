    </main>
    
    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>Brand Bazaar</h3>
                <p>Your one-stop destination for quality products at affordable prices.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-pinterest"></i></a>
                </div>
            </div>
            
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="/index.php">Home</a></li>
                    <li><a href="/trending.php">Trending</a></li>
                    <li><a href="#">Categories</a></li>
                    <li><a href="/contact.php">Contact Us</a></li>
                    <li><a href="/myorders.php">My Orders</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Customer Service</h3>
                <ul>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Shipping Policy</a></li>
                    <li><a href="#">Returns & Refunds</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Contact Info</h3>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> 123 Commerce Street, Business City</li>
                    <li><i class="fas fa-phone"></i> +1 (123) 456-7890</li>
                    <li><i class="fas fa-envelope"></i> support@brandbazaar.com</li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> Brand Bazaar. All rights reserved.</p>
        </div>
    </footer>
    
    <script src="/assets/js/main.js"></script>
    
    <script>
    // Update cart count
    function updateCartCount(count) {
        $('.cart-count').text(count);
    }
    
    // Update wishlist count
    function updateWishlistCount(count) {
        $('.wishlist-count').text(count);
    }
    
    // Initialize counts on page load
    $(document).ready(function() {
        <?php if (isset($_SESSION['user_id'])): ?>
            // Fetch cart count
            $.get('/cart/count.php', function(data) {
                if (data.success) {
                    updateCartCount(data.count);
                }
            });
            
            // Fetch wishlist count
            $.get('/wishlist/count.php', function(data) {
                if (data.success) {
                    updateWishlistCount(data.count);
                }
            });
        <?php endif; ?>
        
        // Mobile menu toggle
        $('.menu-toggle').click(function() {
            $('.mobile-menu').slideToggle();
        });
        
        // User dropdown
        $('.user-btn').click(function(e) {
            e.stopPropagation();
            $('.user-dropdown .dropdown-content').toggle();
        });
        
        // Close dropdown when clicking outside
        $(document).click(function() {
            $('.user-dropdown .dropdown-content').hide();
        });
    });
    </script>
</body>
</html>