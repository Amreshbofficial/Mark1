<?php
// auth.php - Common authentication and database functions

function require_admin_login() {
    if (!isset($_SESSION['admin_logged_in'])) {
        header("Location: /admin/signin.php");
        exit();
    }
}

// Database functions
function get_total_sales($conn) {
    $sql = "SELECT SUM(total) as total FROM orders WHERE status = 'completed'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'] ?? 0;
}

function get_user_count($conn) {
    $sql = "SELECT COUNT(*) as count FROM users";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['count'] ?? 0;
}

function get_order_count($conn) {
    $sql = "SELECT COUNT(*) as count FROM orders";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['count'] ?? 0;
}

function get_product_count($conn) {
    $sql = "SELECT COUNT(*) as count FROM products";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['count'] ?? 0;
}

function get_recent_orders($conn, $limit = 5) {
    $sql = "SELECT o.id, u.name, o.created_at, o.total, o.status 
            FROM orders o 
            JOIN users u ON o.user_id = u.id 
            ORDER BY o.created_at DESC 
            LIMIT $limit";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}