<?php
// templates/issues.php - Updated Reported Issues Page

echo '<div class="container">
    <h1>Reported Issues</h1>';

// TODO: Add logic to fetch and display detailed information about reported issues
$conn = connectDB();
$repository = sanitizeInput($_POST['repository']);

// Fetch reported issues from the database
$stmt = $conn->prepare("SELECT issue_id, issue_title, description, reporter, timestamp, is_resolved FROM reported_issues WHERE repository = ?");
$stmt->bind_param("s", $repository);
$stmt->execute();
$stmt->bind_result($issueId, $issueTitle, $description, $reporter, $timestamp, $isResolved);

while ($stmt->fetch()) {
    echo '<div class="issue">
            <h2>' . $issueTitle . '</h2>
            <p>Description: ' . $description . '</p>
            <p>Reporter: ' . $reporter . '</p>
            <p>Timestamp: ' . $timestamp . '</p>';

    // Display resolution form for unresolved issues
    if (!$isResolved) {
        echo '<form method="post" action="issues.php">
                <input type="hidden" name="issue_id" value="' . $issueId . '">
                <button type="submit" name="resolve_issue">Resolve Issue</button>
            </form>';
    } else {
        // Display a success message for resolved issues
        echo '<p class="success">Issue Resolved!</p>';
    }

    echo '</div>';
}

// Check if the resolution form is submitted
if (isset($_POST['resolve_issue'])) {
    // Get issue_id from the form
    $issueIdToResolve = sanitizeInput($_POST['issue_id']);

    // TODO: Add logic to mark the issue as resolved in the database
    // Update the 'is_resolved' column for the specified issue_id

    // Refresh the page to reflect the updated status
    header("Location: issues.php");
    exit();
}

$stmt->close();
$conn->close();

echo '</div>';
?>
