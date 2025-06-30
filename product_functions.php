<?php
function get_featured_products() {
    global $conn;  // Your database connection
    
    $query = "SELECT * FROM products WHERE featured = 1 LIMIT 8";
    $result = mysqli_query($conn, $query);
    
    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    
    return $products;
}