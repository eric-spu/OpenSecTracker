<?php
// dashboard.php - User Dashboard

// Include necessary files
require_once 'config/config.php';
require_once 'includes/functions.php';
require_once 'includes/auth.php';
require_once 'templates/header.php';

// Check if the user is already logged in
authenticateUser();

// Check if the logout form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    logoutUser();
}

// Display user dashboard content
echo '<div class="container">
    <h1>Welcome to your Dashboard, ' . $_SESSION['username'] . '!</h1>
    <p>This is where you can view and interact with tracked repositories and reported issues.</p>';

// Display tracked repositories for the user
echo '<h2>Your Tracked Repositories</h2>';

// Fetch tracked repositories for the user from the database
$conn = connectDB();
$userRepositories = getUserTrackedRepositories($_SESSION['user_id'], $conn);

echo '<ul>';
foreach ($userRepositories as $userRepo) {
    echo '<li>' . $userRepo['repository_name'] . ' - <a href="' . $userRepo['repository_url'] . '" target="_blank">View</a></li>';
}
echo '</ul>';

// Display reported issues by the user
echo '<h2>Your Reported Issues</h2>';

// Fetch reported issues by the user from the database
$userIssues = getUserReportedIssues($_SESSION['username'], $conn);

echo '<ul>';
foreach ($userIssues as $userIssue) {
    echo '<li>' . $userIssue['issue_title'] . ' - ' . $userIssue['description'] . '</li>';
}
echo '</ul>';

// Display logout form
echo '<form method="post" action="dashboard.php">
        <button type="submit" name="logout">Logout</button>
      </form>';

echo '</div>';

// Include footer
require_once 'templates/footer.php';
?>
