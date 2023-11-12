<?php
// login.php - User Login Page

// Include necessary files
require_once 'config/config.php';
require_once 'includes/functions.php';
require_once 'includes/auth.php';
require_once 'templates/header.php';

// Check if the user is already logged in, redirect to dashboard if true
if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input and sanitize
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);

    // TODO: Add login logic here
    // Authenticate user and retrieve user role
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT user_id, username, password, user_role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $username, $hashed_password, $user_role);

    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        loginUser($user_id, $username, $user_role);
        if ($user_role === 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: dashboard.php");
        }
        exit();
    } else {
        echo '<p class="error">Invalid username or password. Please try again.</p>';
    }

    $stmt->close();
    $conn->close();
}

// Display login form
include 'templates/login.php';

// Include footer
require_once 'templates/footer.php';
?>
