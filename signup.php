<?php
require_once 'includes/config.php';
require_once 'includes/header.php';
?>

<div class="form-container fade-in">
    <h2>Create Account</h2>
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <form action="process_signup.php" method="POST">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" required>
        </div>
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn-primary">Sign Up</button>
    </form>
    <p>Already have an account? <a href="signin.php">Sign In</a></p>
</div>

<?php require_once 'includes/footer.php'; ?>