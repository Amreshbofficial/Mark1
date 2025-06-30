<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database configuration
require_once 'db_connection.php';

// Global functions
require_once 'functions.php';

// Set default timezone
date_default_timezone_set('America/New_York');
?>