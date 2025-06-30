<?php
$pageTitle = "Purchase Confirmation";
require_once 'includes/header.php';
require_once 'includes/config.php';
require_login();

if (!isset($_GET['order_id'])) {
    header("Location: myorders.php");
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
?>

<section class="purchase-section">
    <div class="purchase-container">
        <div class="purchase-success">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>Thank You for Your Purchase!</h1>
            <p>Your order has been successfully placed and is being processed</p>
            
            <div class="order-summary">
                <div class="summary-row">
                    <span>Order ID:</span>
                    <span>#<?= $order['id'] ?></span>
                </div>
                <div class="summary-row">
                    <span>Total Amount:</span>
                    <span>$<?= number_format($order['total'], 2) ?></span>
                </div>
                <div class="summary-row">
                    <span>Estimated Delivery:</span>
                    <span><?= date('M d, Y', strtotime('+3 days')) ?></span>
                </div>
            </div>
            
            <div class="action-buttons">
                <a href="order-details.php?id=<?= $order['id'] ?>" class="btn-primary">
                    View Order Details
                </a>
                <a href="tracking.php?order_id=<?= $order['id'] ?>" class="btn-outline">
                    Track Your Order
                </a>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>