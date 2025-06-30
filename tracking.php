<?php
$pageTitle = "Order Tracking";
require_once 'includes/header.php';
require_once 'includes/config.php';
require_login();
?>

<section class="tracking-section">
    <h1>Track Your Order</h1>
    
    <div class="tracking-form">
        <form id="trackingForm">
            <div class="form-group">
                <label>Order ID</label>
                <input type="text" name="order_id" placeholder="Enter your order number" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <button type="submit" class="btn-primary">Track Order</button>
        </form>
    </div>
    
    <div class="tracking-results" id="trackingResults" style="display: none;">
        <h2>Order Status</h2>
        <div class="tracking-timeline">
            <div class="timeline-step step-received">
                <div class="step-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="step-label">
                    <h4>Order Received</h4>
                    <p>Your order has been placed</p>
                </div>
            </div>
            <div class="timeline-step step-processing">
                <div class="step-icon">
                    <i class="fas fa-cog"></i>
                </div>
                <div class="step-label">
                    <h4>Processing</h4>
                    <p>Preparing your order</p>
                </div>
            </div>
            <div class="timeline-step step-shipped">
                <div class="step-icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <div class="step-label">
                    <h4>Shipped</h4>
                    <p>Your order is on the way</p>
                </div>
            </div>
            <div class="timeline-step step-delivered">
                <div class="step-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="step-label">
                    <h4>Delivered</h4>
                    <p>Order delivered successfully</p>
                </div>
            </div>
        </div>
        
        <div class="tracking-details">
            <div class="detail-card">
                <h3>Order Summary</h3>
                <div class="detail-row">
                    <span>Order ID:</span>
                    <span id="order-id">#12345</span>
                </div>
                <div class="detail-row">
                    <span>Order Date:</span>
                    <span id="order-date">Oct 15, 2023</span>
                </div>
                <div class="detail-row">
                    <span>Total Amount:</span>
                    <span id="order-total">$129.99</span>
                </div>
                <div class="detail-row">
                    <span>Shipping Address:</span>
                    <span id="order-address">123 Main St, Anytown, USA</span>
                </div>
            </div>
            
            <div class="detail-card">
                <h3>Shipping Updates</h3>
                <div class="updates-list">
                    <div class="update-item">
                        <div class="update-time">Oct 18, 2023 10:30 AM</div>
                        <div class="update-text">Order has been delivered</div>
                    </div>
                    <div class="update-item">
                        <div class="update-time">Oct 17, 2023 9:15 AM</div>
                        <div class="update-text">Out for delivery</div>
                    </div>
                    <div class="update-item">
                        <div class="update-time">Oct 16, 2023 3:45 PM</div>
                        <div class="update-text">Package departed from distribution center</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('trackingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    // In a real application, this would fetch data from the server
    document.getElementById('trackingResults').style.display = 'block';
    window.scrollTo({
        top: document.getElementById('trackingResults').offsetTop - 100,
        behavior: 'smooth'
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>