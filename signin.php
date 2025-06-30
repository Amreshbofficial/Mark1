<?php
$pageTitle = "Sign In";
require_once 'includes/config.php';
require_once 'includes/header.php';

if (is_logged_in()) {
    header("Location: profile.php");
    exit();
}
?>

<div class="form-container fade-in">
    <h2>Sign In to Your Account</h2>
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <form action="process_signin.php" method="POST">
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn-primary">Sign In</button>
    </form>
    <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
</div>

<?php require_once 'includes/footer.php'; ?>