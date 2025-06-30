<?php
$pageTitle = "Checkout";
require_once 'includes/header.php';
require_once 'includes/config.php';
require_login();

// Ensure cart is not empty
$user_id = $_SESSION['user_id'];
$sql = "SELECT c.*, p.name, p.price, p.image 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

if (count($cart_items) === 0) {
    header("Location: cart.php");
    exit();
}

// Calculate totals
$subtotal = 0;
foreach ($cart_items as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$shipping = $subtotal > 50 ? 0 : 5.99;
$total = $subtotal + $shipping;

// Get user info
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<section class="checkout-section">
    <h1>Checkout</h1>
    
    <div class="checkout-container">
        <div class="checkout-form">
            <h2>Shipping Information</h2>
            <form id="checkoutForm">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" value="<?= $user['name'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="<?= $user['email'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" required><?= $user['address'] ?></textarea>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" value="<?= $user['phone'] ?>" required>
                </div>
                
                <h2>Payment Method</h2>
                <div class="payment-methods">
                    <div class="payment-method">
                        <input type="radio" id="creditCard" name="payment_method" value="credit_card" checked>
                        <label for="creditCard">Credit Card</label>
                    </div>
                    <div class="payment-method">
                        <input type="radio" id="paypal" name="payment_method" value="paypal">
                        <label for="paypal">PayPal</label>
                    </div>
                    <div class="payment-method">
                        <input type="radio" id="cod" name="payment_method" value="cod">
                        <label for="cod">Cash on Delivery</label>
                    </div>
                </div>
                
                <div id="creditCardForm">
                    <div class="form-group">
                        <label>Card Number</label>
                        <input type="text" name="card_number" placeholder="1234 5678 9012 3456" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Expiry Date</label>
                            <input type="text" name="expiry" placeholder="MM/YY" required>
                        </div>
                        <div class="form-group">
                            <label>CVV</label>
                            <input type="text" name="cvv" placeholder="123" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Cardholder Name</label>
                        <input type="text" name="card_name" required>
                    </div>
                </div>
                
                <button type="submit" class="btn-primary">Place Order</button>
            </form>
        </div>
        
        <div class="order-summary">
            <h2>Order Summary</h2>
            <div class="summary-items">
                <?php foreach ($cart_items as $item) : ?>
                <div class="summary-item">
                    <div class="item-info">
                        <img src="/assets/images/products/<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
                        <div>
                            <h4><?= $item['name'] ?></h4>
                            <p>Qty: <?= $item['quantity'] ?></p>
                        </div>
                    </div>
                    <div class="item-price">$<?= number_format($item['price'] * $item['quantity'], 2) ?></div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="summary-totals">
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span>$<?= number_format($subtotal, 2) ?></span>
                </div>
                <div class="summary-row">
                    <span>Shipping:</span>
                    <span>$<?= number_format($shipping, 2) ?></span>
                </div>
                <div class="summary-row total">
                    <span>Total:</span>
                    <span>$<?= number_format($total, 2) ?></span>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle payment method selection
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const creditCardForm = document.getElementById('creditCardForm');
    
    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            if (this.value === 'credit_card') {
                creditCardForm.style.display = 'block';
            } else {
                creditCardForm.style.display = 'none';
            }
        });
    });
    
    // Handle form submission
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Process payment and create order
        fetch('process_checkout.php', {
            method: 'POST',
            body: new FormData(this)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'payment.php?order_id=' + data.order_id;
            } else {
                alert('Error: ' + data.message);
            }
        });
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>