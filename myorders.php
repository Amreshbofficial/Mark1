<?php
$pageTitle = "My Orders";
require_once 'includes/header.php';
require_once 'includes/config.php';
require_login();

$user_id = $_SESSION['user_id'];
$sql = "SELECT o.id, o.total, o.status, o.created_at 
        FROM orders o 
        WHERE o.user_id = ? 
        ORDER BY o.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<section class="my-orders">
    <h1>My Orders</h1>
    
    <?php if ($result->num_rows === 0) : ?>
        <div class="empty-orders">
            <i class="fas fa-box-open"></i>
            <h3>You haven't placed any orders yet</h3>
            <p>Start shopping to see your orders here</p>
            <a href="index.php" class="btn-primary">Shop Now</a>
        </div>
    <?php else : ?>
        <div class="orders-list">
            <table>
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $result->fetch_assoc()) : ?>
                    <tr>
                        <td>#<?= $order['id'] ?></td>
                        <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                        <td>$<?= number_format($order['total'], 2) ?></td>
                        <td>
                            <span class="status-badge <?= $order['status'] ?>">
                                <?= ucfirst($order['status']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="order-details.php?id=<?= $order['id'] ?>" class="btn-view">
                                View Details
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>

<?php require_once 'includes/footer.php'; ?>