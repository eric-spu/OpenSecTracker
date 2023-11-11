<?php
// register.php - User Registration Page

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

    // Check if the username is available
    $conn = connectDB();
    if (isUsernameAvailable($username, $conn)) {
        // Register the user
        if (registerUser($username, $password, $conn)) {
            // Redirect to login page after registration
            header("Location: login.php");
            exit();
        } else {
            $registrationError = "Registration failed. Please try again.";
        }
    } else {
        $registrationError = "Username is already taken. Please choose another.";
    }

    // Close the database connection
    $conn->close();
}

// Display registration form
include 'templates/register.php';

// Include footer
require_once 'templates/footer.php';
?>
