<?php
require_once '../../includes/config.php'; // Added: ensures $conn is set
require_once '../../includes/auth.php';
require_admin_login();
require_once '../../includes/admin_functions.php'; // if your get_all_orders() is here
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Orders</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <?php include '../includes/admin-header.php'; ?>
    
    <div class="admin-container">
        <?php include '../includes/sidebar.php'; ?>
        
        <main class="admin-content">
            <h1>Manage Orders</h1>
            
            <div class="filters">
                <form method="GET">
                    <div class="form-group">
                        <label>Status:</label>
                        <select name="status">
                            <option value="">All</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date Range:</label>
                        <input type="date" name="start_date">
                        <span>to</span>
                        <input type="date" name="end_date">
                    </div>
                    <button type="submit" class="btn-primary">Filter</button>
                </form>
            </div>
            
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $orders = get_all_orders($conn, $_GET ?? []);
                        if ($orders) :
                        foreach ($orders as $order) : 
                        ?>
                        <tr>
                            <td>#<?= (int)$order['id'] ?></td>
                            <td><?= htmlspecialchars($order['name']) ?></td>
                            <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                            <td>$<?= number_format($order['total'], 2) ?></td>
                            <td>
                                <span class="status-badge <?= htmlspecialchars($order['status']) ?>">
                                    <?= ucfirst(htmlspecialchars($order['status'])) ?>
                                </span>
                            </td>
                            <td class="actions">
                                <a href="view_order.php?id=<?= (int)$order['id'] ?>" class="btn-view">View</a>
                                <a href="edit_order.php?id=<?= (int)$order['id'] ?>" class="btn-edit">Edit</a>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="6">No orders found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    
    <script src="/assets/js/admin.js"></script>
</body>
</html>