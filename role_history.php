<?php
// role_history.php - Page to View User Role Change History

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

// Display role change history content
echo '<div class="container">
    <h1>User Role Change History, ' . $_SESSION['username'] . '!</h1>
    <p>This is where administrators can view the history of user role changes.</p>';

// Fetch user role change history
$conn = connectDB();
$roleChanges = getRoleChangeHistory($conn);

// Display role change history in a table
echo '<h2>Role Change History</h2>';
echo '<table>
        <tr>
            <th>Username</th>
            <th>Previous Role</th>
            <th>New Role</th>
            <th>Changed By</th>
            <th>Timestamp</th>
        </tr>';

foreach ($roleChanges as $change) {
    echo '<tr>
            <td>' . $change['username'] . '</td>
            <td>' . $change['previous_role'] . '</td>
            <td>' . $change['new_role'] . '</td>
            <td>' . $change['changed_by'] . '</td>
            <td>' . $change['timestamp'] . '</td>
        </tr>';
}

echo '</table>';

$conn->close();

echo '</div>';

// Include footer
require_once 'templates/footer.php';
?>
