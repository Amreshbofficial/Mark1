<?php
$pageTitle = "My Profile";
require_once 'includes/config.php';
require_once 'includes/header.php';
require_once 'includes/auth.php';
require_login();

// Get user data
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    header("Location: signin.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize_input($_POST['name'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $phone = sanitize_input($_POST['phone'] ?? '');
    $address = sanitize_input($_POST['address'] ?? '');

    // Check if email is already used
    $check_sql = "SELECT id FROM users WHERE email = ? AND id != ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("si", $email, $user_id);
    $check_stmt->execute();

    if ($check_stmt->get_result()->num_rows > 0) {
        $error = "Email address is already in use by another account.";
    } else {
        // Update user
        $update_sql = "UPDATE users SET name = ?, email = ?, phone = ?, address = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssssi", $name, $email, $phone, $address, $user_id);

        if ($update_stmt->execute()) {
            $_SESSION['user_name'] = $name;
            $success = "Profile updated successfully!";
            $user['name'] = $name;
            $user['email'] = $email;
            $user['phone'] = $phone;
            $user['address'] = $address;
        } else {
            $error = "Failed to update profile. Please try again.";
        }
    }
}
?>

<section class="profile-section">
    <div class="profile-container">
        <div class="profile-sidebar">
            <div class="profile-summary">
                <div class="profile-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h3><?= htmlspecialchars($user['name']) ?></h3>
                <p><?= htmlspecialchars($user['email']) ?></p>
            </div>
            <ul class="profile-menu">
                <li class="active"><a href="profile.php"><i class="fas fa-user"></i> My Profile</a></li>
                <li><a href="myorders.php"><i class="fas fa-shopping-bag"></i> My Orders</a></li>
                <li><a href="wishlist.php"><i class="fas fa-heart"></i> Wishlist</a></li>
                <li><a href="change-password.php"><i class="fas fa-lock"></i> Change Password</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
        <div class="profile-content">
            <h1>My Profile</h1>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <form class="profile-form" method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" rows="3"><?= htmlspecialchars($user['address']) ?></textarea>
                    </div>
                </div>
                <button type="submit" class="btn-primary">Update Profile</button>
            </form>
            <div class="profile-security">
                <h2>Account Security</h2>
                <div class="security-info">
                    <p><strong>Password:</strong> Last changed on <?= date('M d, Y', strtotime($user['created_at'])) ?></p>
                    <a href="change-password.php" class="btn-outline">Change Password</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>