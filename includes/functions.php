<?php
// includes/functions.php - Functions and utilities

// Function to establish a database connection
function connectDB() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

// Function to sanitize user input
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags($input));
}

// includes/functions.php - Functions and utilities

// ... (previous functions)

// Function to check if a username is available
function isUsernameAvailable($username, $conn) {
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $count = $stmt->num_rows;
    $stmt->close();

    return $count === 0;
}

// Function to register a new user
function registerUser($username, $password, $conn) {
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into the database
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }

    $stmt->close();
}

// Function to authenticate and log in a user
function loginUserLogic($username, $password, $conn) {
    // Retrieve hashed password from the database
    $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $hashedPassword);
    $stmt->fetch();
    $stmt->close();

    // Verify password
    if (password_verify($password, $hashedPassword)) {
        loginUser($user_id, $username);
        return true;
    } else {
        return false;
    }
}




?>
