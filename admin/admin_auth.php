<?php
// admin_auth.php - Admin authentication check
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: signin.php");
    exit();
}