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

    // Authenticate and log in the user
    $conn = connectDB();
    if (loginUserLogic($username, $password, $conn)) {
        // Redirect to dashboard after successful login
        header("Location: dashboard.php");
        exit();
    } else {
        $loginError = "Invalid username or password. Please try again.";
    }

    // Close the database connection
    $conn->close();
}

// Display login form
include 'templates/login.php';

// Include footer
require_once 'templates/footer.php';
?>
