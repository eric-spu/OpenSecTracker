<?php
// register.php

// Include necessary files
require_once 'config/config.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

// Check if the registration form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    // Retrieve and sanitize input data
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);
    $confirmPassword = sanitizeInput($_POST['confirm_password']);
    $userRole = sanitizeInput($_POST['user_role']);  // New field for user role

    // Validate input data
    $errors = array();

    if (empty($username) || empty($password) || empty($confirmPassword) || empty($userRole)) {
        $errors[] = 'All fields are required.';
    }

    if ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match.';
    }

    // If no validation errors, proceed with registration
    if (empty($errors)) {
        // Hash the password before storing in the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Register the user in the database
        registerUser($username, $hashedPassword, $userRole);

        // Redirect to login page after successful registration
        header('Location: login.php');
        exit();
    }
}

// Include header
require_once 'templates/header.php';
?>

<div class="container">
    <h2>Register</h2>

    <?php
    // Display validation errors
    if (!empty($errors)) {
        echo '<div class="error">';
        foreach ($errors as $error) {
            echo '<p>' . $error . '</p>';
        }
        echo '</div>';
    }
    ?>

    <!-- Registration form -->
    <form method="post" action="register.php">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required>

        <label for="user_role">User Role:</label>
        <select name="user_role" id="user_role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit" name="register">Register</button>
    </form>
</div>

<!-- Include footer -->
<?php require_once 'templates/footer.php'; ?>
