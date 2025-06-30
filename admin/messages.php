<?php
require_once 'admin_auth.php';
require_once '../includes/config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Messages</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <?php include 'includes/admin-header.php'; ?>
    
    <div class="admin-container">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="admin-content">
            <h1>Contact Messages</h1>
            
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?= (int)$row['id'] ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars(mb_strimwidth($row['message'], 0, 50, "...")) ?></td>
                            <td><?= date('M d, Y', strtotime($row['created_at'])) ?></td>
                            <td>
                                <a href="view_message.php?id=<?= (int)$row['id'] ?>" class="btn-view">View</a>
                                <form action="delete_message.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                    <button type="submit" class="btn-delete" onclick="return confirm('Delete this message?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; 
                    } else {
                        echo "<tr><td colspan='6'>No messages found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </div>
    
    <script src="/assets/js/admin.js"></script>
</body>
</html>