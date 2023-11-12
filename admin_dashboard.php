<?php
// admin_dashboard.php - Admin Dashboard Page

// Include necessary files
require_once 'config/config.php';
require_once 'includes/functions.php';
require_once 'includes/auth.php';
require_once 'includes/admin_functions.php'; // Include admin functions
require_once 'templates/header.php';

// Authenticate user and check if the user is an admin
authenticateUser();
if (!isAdmin()) {
    // Redirect non-admin users to the regular dashboard
    header("Location: dashboard.php");
    exit();
}

// Check if the logout form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    logoutUser();
}

// Display admin dashboard content
echo '<div class="container">
    <h1 ><span style="font-size: 20px;">OpenSecTracker Admin Panel, </span>
    <span style="color: green; font-size: 16px;">' . $_SESSION['username'] . '!</span>
    </h1>
    <p>This is where administrators can access additional functionalities.</p>';

// Display a list of tracked repositories
echo '<h2>Tracked Repositories</h2>';

// Fetch tracked repositories from the database
$conn = connectDB();
$repositories = getTrackedRepositories($conn);

echo '<ul>';
foreach ($repositories as $repository) {
    echo '<li>' . $repository['repository_name'] . ' - <a href="' . $repository['repository_url'] . '" target="_blank">View</a> | <a href="admin_dashboard.php?edit_repo=' . $repository['repository_id'] . '">Edit</a> | <a href="admin_dashboard.php?delete_repo=' . $repository['repository_id'] . '">Delete</a></li>';
}
echo '</ul>';

// Check if the edit_repo or delete_repo parameter is set in the URL
if (isset($_GET['edit_repo'])) {
    // Get the repository_id to edit
    $editRepoId = sanitizeInput($_GET['edit_repo']);

    // Fetch repository details
    $repoDetails = getRepositoryDetails($editRepoId, $conn);

    echo '<h2>Edit Repository</h2>
        <form method="post" action="admin_dashboard.php">
            <input type="hidden" name="edit_repo_id" value="' . $editRepoId . '">
            <label for="edit_repo_name">Repository Name:</label>
            <input type="text" name="edit_repo_name" value="' . $repoDetails['repository_name'] . '" required>

            <label for="edit_repo_url">Repository URL:</label>
            <input type="url" name="edit_repo_url" value="' . $repoDetails['repository_url'] . '" required>

            <button type="submit" name="update_repo">Update Repository</button>
        </form>';
} else {
    // Display add repository form
    echo '<h2>Add Repository</h2>
        <form method="post" action="admin_dashboard.php">
            <label for="repo_name">Repository Name:</label>
            <input type="text" name="repo_name" required>

            <label for="repo_url">Repository URL:</label>
            <input type="url" name="repo_url" required>

            <button type="submit" name="add_repo">Add Repository</button>
        </form>';

}



// Check if the add_repo form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_repo'])) {
    // Get user input and sanitize
    $repoName = sanitizeInput($_POST['repo_name']);
    $repoUrl = sanitizeInput($_POST['repo_url']);

    // Add the repository to the database
    addRepository($repoName, $repoUrl, $conn);

    // Refresh the page to reflect the updated list of repositories
    header("Location: admin_dashboard.php");
    exit();
}

// Check if the update_repo form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_repo'])) {
    // Get user input and sanitize
    $editRepoId = sanitizeInput($_POST['edit_repo_id']);
    $editRepoName = sanitizeInput($_POST['edit_repo_name']);
    $editRepoUrl = sanitizeInput($_POST['edit_repo_url']);

    // Update the repository in the database
    updateRepository($editRepoId, $editRepoName, $editRepoUrl, $conn);

    // Refresh the page to reflect the updated list of repositories
    header("Location: admin_dashboard.php");
    exit();
}

// Check if the delete_repo parameter is set in the URL
if (isset($_GET['delete_repo'])) {
    // Get the repository_id to delete
    $deleteRepoId = sanitizeInput($_GET['delete_repo']);

    // Delete the repository from the database
    deleteRepository($deleteRepoId, $conn);

    // Refresh the page to reflect the updated list of repositories
    header("Location: admin_dashboard.php");
    exit();
}

echo '</div>';

// Include footer
require_once 'templates/footer.php';
?>
