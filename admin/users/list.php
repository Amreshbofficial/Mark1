<?php
require_once '../../includes/auth.php';
require_admin_login();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <?php include '../includes/admin-header.php'; ?>
    
    <div class="admin-container">
        <?php include '../includes/sidebar.php'; ?>
        
        <main class="admin-content">
            <h1>Manage Users</h1>
            
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Registered</th>
                            <th>Orders</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT u.*, COUNT(o.id) as order_count 
                                FROM users u 
                                LEFT JOIN orders o ON u.id = o.user_id 
                                GROUP BY u.id";
                        $result = $conn->query($sql);
                        
                        while ($user = $result->fetch_assoc()) : 
                        ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= $user['name'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                            <td><?= $user['order_count'] ?></td>
                            <td class="actions">
                                <a href="view_user.php?id=<?= $user['id'] ?>" class="btn-view">View</a>
                                <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn-edit">Edit</a>
                                <form action="delete_user.php" method="POST" class="delete-form">
                                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    
    <script src="/assets/js/admin.js"></script>
</body>
</html>