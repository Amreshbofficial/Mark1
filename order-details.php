<?php
$pageTitle = "Order Details";
require_once 'includes/header.php';
require_once 'includes/config.php';
require_login();

if (!isset($_GET['id'])) {
    header("Location: myorders.php");
    exit();
}

$order_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Get order details
$sql = "SELECT o.*, u.name, u.email, u.address, u.phone 
        FROM orders o 
        JOIN users u ON o.user_id = u.id 
        WHERE o.id = ? AND o.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    header("Location: myorders.php");
    exit();
}

// Get order items
$sql = "SELECT oi.*, p.name, p.image 
        FROM order_items oi 
        JOIN products p ON oi.product_id = p.id 
        WHERE oi.order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<section class="order-details-section">
    <h1>Order Details #<?= $order['id'] ?></h1>
    
    <div class="order-status-bar">
        <div class="status-step <?= $order['status'] === 'pending' ? 'active' : '' ?>">
            <div class="step-icon">1</div>
            <div class="step-label">Pending</div>
        </div>
        <div class="status-step <?= $order['status'] === 'processing' ? 'active' : '' ?>">
            <div class="step-icon">2</div>
            <div class="step-label">Processing</div>
        </div>
        <div class="status-step <?= $order['status'] === 'shipped' ? 'active' : '' ?>">
            <div class="step-icon">3</div>
            <div class="step-label">Shipped</div>
        </div>
        <div class="status-step <?= $order['status'] === 'delivered' ? 'active' : '' ?>">
            <div class="step-icon">4</div>
            <div class="step-label">Delivered</div>
        </div>
    </div>
    
    <div class="order-details-container">
        <div class="order-items">
            <h2>Order Items</h2>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item) : ?>
                    <tr>
                        <td class="product-info">
                            <img src="/assets/images/products/<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
                            <div>
                                <h4><?= $item['name'] ?></h4>
                                <p>SKU: PROD-<?= $item['product_id'] ?></p>
                            </div>
                        </td>
                        <td>$<?= number_format($item['price'], 2) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="order-summary">
            <div class="summary-card">
                <h3>Order Summary</h3>
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span>$<?= number_format($order['total'] - ($order['total'] > 50 ? 0 : 5.99), 2) ?></span>
                </div>
                <div class="summary-row">
                    <span>Shipping:</span>
                    <span>$<?= number_format($order['total'] > 50 ? 0 : 5.99, 2) ?></span>
                </div>
                <div class="summary-row total">
                    <span>Total:</span>
                    <span>$<?= number_format($order['total'], 2) ?></span>
                </div>
            </div>
            
            <div class="summary-card">
                <h3>Shipping Information</h3>
                <div class="shipping-info">
                    <p><strong><?= $order['name'] ?></strong></p>
                    <p><?= $order['address'] ?></p>
                    <p>Phone: <?= $order['phone'] ?></p>
                    <p>Email: <?= $order['email'] ?></p>
                </div>
            </div>
            
            <div class="summary-card">
                <h3>Payment Information</h3>
                <div class="payment-info">
                    <p><strong>Payment Method:</strong> Credit Card</p>
                    <p><strong>Transaction ID:</strong> TXN-<?= strtoupper(bin2hex(random_bytes(4))) ?></p>
                    <p><strong>Payment Status:</strong> Completed</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>