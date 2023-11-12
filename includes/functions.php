<?php
// includes/functions.php

// Function to sanitize input data
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Function to establish a database connection
function connectDB() {
    $dbHost = 'localhost'; // Replace with your database host
    $dbUser = 'root'; // Replace with your database username
    $dbPass = ''; // Replace with your database password
    $dbName = 'securitydb'; // Replace with your database name

    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    return $conn;
}

// Function to close the database connection
function closeDB($conn) {
    $conn->close();
}

// Function to register a new user
function registerUser($username, $password, $userRole) {
    $conn = connectDB();

    // Check if the username already exists
    $checkUserQuery = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($checkUserQuery);

    if ($result->num_rows > 0) {
        // Username already exists, handle accordingly (display error or redirect, etc.)
        // For simplicity, we'll exit with an error message
        echo 'Username already exists.';
        exit();
    }

    // Insert user into the database
    $insertUserQuery = "INSERT INTO users (username, password, user_role) VALUES ('$username', '$password', '$userRole')";
    $conn->query($insertUserQuery);

    closeDB($conn);
}




// Function to report an issue
function reportIssue($issueTitle, $description, $reporter) {
    $conn = connectDB();

    // TODO: Add code to insert issue into the database (e.g., use MySQL INSERT statement)

    closeDB($conn);
}

// Function to fetch tracked repositories
function getTrackedRepositories() {
    // Establish a database connection
    $conn = connectDB();

    // TODO: Replace this with the actual code to fetch repositories from the database
    $result = $conn->query("SELECT * FROM tracked_repositories");

    // Check if the query was successful
    if ($result) {
        // Fetch all rows as an associative array
        $repositories = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        // Handle the case where the query fails (display error, log, etc.)
        $repositories = array(); // or set it to an empty array, depending on your error-handling strategy
    }

    // Close the database connection
    closeDB($conn);

    // Return the fetched repositories
    return $repositories;
}

// Function to add a tracked repository
function addTrackedRepository($repoName, $repoUrl) {
    // Establish a database connection
    $conn = connectDB();

    // Sanitize input data to prevent SQL injection
    $safeRepoName = $conn->real_escape_string($repoName);
    $safeRepoUrl = $conn->real_escape_string($repoUrl);

    // TODO: Replace this with the actual code to insert repository into the database
    $insertQuery = "INSERT INTO tracked_repositories (repo_name, repo_url) VALUES ('$safeRepoName', '$safeRepoUrl')";

    // Execute the insert query
    $result = $conn->query($insertQuery);

    // Check if the query was successful
    if ($result) {
        // Success
        $success = true;
        $message = 'Repository added successfully!';
    } else {
        // Failure
        $success = false;
        $message = 'Failed to add repository.';
    }

    // Close the database connection
    closeDB($conn);

    // Use SweetAlert to display the result
    echo "<script>
            if ($success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '$message',
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '$message',
                });
            }
        </script>";

    // Return the result of the insert operation (true for success, false for failure)
    return $success;
}


// Function to fetch repository details
function getRepositoryDetails($repoId) {
    $conn = connectDB();

    // TODO: Add code to fetch repository details from the database (e.g., use MySQL SELECT statement)

    closeDB($conn);
    return $repositoryDetails; // Return the fetched repository details
}

// Function to update a tracked repository
function updateTrackedRepository($repoId, $repoName, $repoUrl) {
    $conn = connectDB();

    // TODO: Add code to update repository in the database (e.g., use MySQL UPDATE statement)

    closeDB($conn);
}

// Function to delete a tracked repository
function deleteTrackedRepository($repoId) {
    $conn = connectDB();

    // TODO: Add code to delete repository from the database (e.g., use MySQL DELETE statement)

    closeDB($conn);
}
?>
