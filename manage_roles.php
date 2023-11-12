<?php
// manage_roles.php - Admin Page to Manage User Roles

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

// Display admin page content
echo '<div class="container">
    <h1>Manage User Roles, ' . $_SESSION['username'] . '!</h1>
    <p>This is where administrators can manage user roles.</p>';

// Fetch users and their roles
$conn = connectDB();
$users = getUsersAndRoles($conn);

// Display user list in a table
echo '<h2>User List</h2>';
echo '<table>
        <tr>
            <th>Username</th>
            <th>User Role</th>
            <th>Action</th>
        </tr>';

foreach ($users as $user) {
    echo '<tr>
            <td>' . $user['username'] . '</td>
            <td>' . $user['user_role'] . '</td>
            <td>
                <form method="post" action="manage_roles.php">
                    <input type="hidden" name="user_id" value="' . $user['user_id'] . '">
                    <select name="new_role">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                    <button type="submit" name="update_role">Update Role</button>
                </form>
            </td>
        </tr>';
}

echo '</table>';

// Check if the role update form is submitted
if (isset($_POST['update_role'])) {
    // Get user_id and new_role from the form
    $user_idToUpdate = sanitizeInput($_POST['user_id']);
    $new_role = sanitizeInput($_POST['new_role']);

    // Update user role in the database
    updateUserRole($user_idToUpdate, $new_role, $conn);
    
    // Refresh the page to reflect the updated user roles
    header("Location: manage_roles.php");
    exit();
}

$conn->close();

echo '</div>';

// Include footer
require_once 'templates/footer.php';
?>
