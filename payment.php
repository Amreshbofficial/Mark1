<?php
$pageTitle = "Payment";
require_once 'includes/header.php';
require_once 'includes/config.php';
require_login();

if (!isset($_GET['order_id'])) {
    header("Location: checkout.php");
    exit();
}

$order_id = intval($_GET['order_id']);
$user_id = $_SESSION['user_id'];

// Verify order belongs to user
$sql = "SELECT * FROM orders WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    header("Location: myorders.php");
    exit();
}

// Get order items
$sql = "SELECT oi.*, p.name 
        FROM order_items oi 
        JOIN products p ON oi.product_id = p.id 
        WHERE oi.order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<section class="payment-section">
    <div class="payment-container">
        <div class="payment-success">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>Payment Successful!</h1>
            <p>Thank you for your order. Your payment has been processed successfully.</p>
            
            <div class="order-summary">
                <div class="summary-row">
                    <span>Order ID:</span>
                    <span>#<?= $order['id'] ?></span>
                </div>
                <div class="summary-row">
                    <span>Date:</span>
                    <span><?= date('M d, Y H:i', strtotime($order['created_at'])) ?></span>
                </div>
                <div class="summary-row">
                    <span>Total Amount:</span>
                    <span>$<?= number_format($order['total'], 2) ?></span>
                </div>
                <div class="summary-row">
                    <span>Payment Method:</span>
                    <span><?= ucfirst($order['payment_method']) ?></span>
                </div>
            </div>
            
            <div class="action-buttons">
                <a href="order-details.php?id=<?= $order['id'] ?>" class="btn-primary">
                    View Order Details
                </a>
                <a href="index.php" class="btn-outline">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>