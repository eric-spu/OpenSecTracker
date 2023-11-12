<?php
// templates/dashboard.php - Updated Dashboard content

echo '<div class="container">
    <h1>Welcome to your Dashboard, ' . $_SESSION['username'] . '!</h1>
    <p>This is where you can view and interact with tracked repositories and reported issues.</p>';

// Display form to choose a repository
echo '<form method="post" action="dashboard.php">
        <label for="repository">Choose a Repository:</label>
        <input type="text" name="repository" required>
        <button type="submit">Track Repository</button>
    </form>';

// Check if a repository is chosen
if (isset($_POST['repository'])) {
    $repository = sanitizeInput($_POST['repository']);

    // Display form to report an issue
    echo '<form method="post" action="dashboard.php">
            <h2>Report an Issue</h2>
            <label for="issue">Issue Description:</label>
            <textarea name="issue" required></textarea>
            <button type="submit">Report Issue</button>
        </form>';

    // TODO: Add logic to track the chosen repository
    // You can use APIs or other methods to fetch repository details
    // Save the repository details in the database for tracking

    // Display tracked repository information
    echo '<h2>Tracked Repository Information</h2>';
    echo '<p>Repository Name: ' . $repository . '</p>';
    
    // Display reported issues for the tracked repository
    echo '<h2>Reported Issues</h2>';
    echo '<a href="issues.php">View Reported Issues</a>';
}

echo '</div>';
?>
