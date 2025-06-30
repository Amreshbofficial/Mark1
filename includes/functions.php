<?php
// Get total sales amount
function get_total_sales($conn) {
    $sql = "SELECT SUM(total) as total_sales FROM orders";
    $result = $conn->query($sql);
    return $result->fetch_assoc()['total_sales'] ?? 0;
}

// Get user count
function get_user_count($conn) {
    $sql = "SELECT COUNT(*) as count FROM users";
    $result = $conn->query($sql);
    return $result->fetch_assoc()['count'];
}

// Get order count
function get_order_count($conn) {
    $sql = "SELECT COUNT(*) as count FROM orders";
    $result = $conn->query($sql);
    return $result->fetch_assoc()['count'];
}

// Get product count
function get_product_count($conn) {
    $sql = "SELECT COUNT(*) as count FROM products";
    $result = $conn->query($sql);
    return $result->fetch_assoc()['count'];
}

// Get recent orders
function get_recent_orders($conn, $limit = 5) {
    $sql = "SELECT o.id, u.name, o.total, o.status, o.created_at 
            FROM orders o 
            JOIN users u ON o.user_id = u.id 
            ORDER BY o.created_at DESC 
            LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Get all orders with filters
function get_all_orders($conn, $filters = []) {
    $status = $filters['status'] ?? '';
    $start_date = $filters['start_date'] ?? '';
    $end_date = $filters['end_date'] ?? '';
    
    $sql = "SELECT o.id, u.name, o.total, o.status, o.created_at 
            FROM orders o 
            JOIN users u ON o.user_id = u.id 
            WHERE 1=1";
    
    $params = [];
    $types = '';
    
    if ($status) {
        $sql .= " AND o.status = ?";
        $params[] = $status;
        $types .= 's';
    }
    
    if ($start_date && $end_date) {
        $sql .= " AND o.created_at BETWEEN ? AND ?";
        $params[] = $start_date . ' 00:00:00';
        $params[] = $end_date . ' 23:59:59';
        $types .= 'ss';
    }
    
    $sql .= " ORDER BY o.created_at DESC";
    
    $stmt = $conn->prepare($sql);
    
    if ($params) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}