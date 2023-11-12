<?php
// includes/auth.php - User Authentication and Session Management

// Include necessary files
require_once 'functions.php';
require_once 'config/config.php';

// Start the session
session_start();

// Function to check if the user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Function to redirect unauthenticated users to the login page
function authenticateUser() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

// Function to check if the user is an admin
function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

// Function to log in a user
function loginUser($user_id, $username, $user_role) {
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;
    $_SESSION['user_role'] = $user_role;
}

// Function to log out a user
function logoutUser() {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
