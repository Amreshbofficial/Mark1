<?php
// dashboard.php - Admin dashboard
require_once 'admin_auth.php';
require_once '../includes/config.php';
require_once '../includes/auth.php'; // This now contains our database functions
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <?php include 'includes/admin-header.php'; ?>
    
    <div class="admin-container">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="admin-content">
            <h1>Welcome, <?= htmlspecialchars($_SESSION['admin_username']) ?></h1>
            <p class="admin-subtitle">Dashboard Overview</p>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value">$<?= number_format(get_total_sales($conn), 2) ?></div>
                    <div class="stat-label">Total Sales</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?= get_user_count($conn) ?></div>
                    <div class="stat-label">Registered Users</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?= get_order_count($conn) ?></div>
                    <div class="stat-label">Total Orders</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?= get_product_count($conn) ?></div>
                    <div class="stat-label">Products</div>
                </div>
            </div>
            
            <div class="recent-orders">
                <h2>Recent Orders</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (get_recent_orders($conn) as $order) : ?>
                        <tr>
                            <td>#<?= $order['id'] ?></td>
                            <td><?= htmlspecialchars($order['name']) ?></td>
                            <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                            <td>$<?= number_format($order['total'], 2) ?></td>
                            <td>
                                <span class="status-badge <?= $order['status'] ?>">
                                    <?= ucfirst($order['status']) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/assets/js/admin.js"></script>
</body>
</html>