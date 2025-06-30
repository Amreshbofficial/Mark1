<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize_input($_POST['name'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (!$name || !$email || !$password) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: signup.php");
        exit();
    }
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Check if email exists
    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    if ($stmt->get_result()->num_rows > 0) {
        $_SESSION['error'] = "Email already registered";
        header("Location: signup.php");
        exit();
    }

    // Insert new user
    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $password_hash);

    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $name;
        header("Location: profile.php");
        exit();
    } else {
        $_SESSION['error'] = "Registration failed";
        header("Location: signup.php");
        exit();
    }
}
header("Location: signup.php");
exit();