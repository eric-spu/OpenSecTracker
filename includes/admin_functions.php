<?php
require_once 'config/config.php';
require_once 'includes/admin_functions.php';
require_once 'includes/functions.php';

// Function to fetch a list of users and their roles
function getUsersAndRoles($conn) {
    $users = array();

    $stmt = $conn->prepare("SELECT user_id, username, user_role FROM users");
    $stmt->execute();
    $stmt->bind_result($user_id, $username, $user_role);

    while ($stmt->fetch()) {
        $users[] = array(
            'user_id' => $user_id,
            'username' => $username,
            'user_role' => $user_role
        );
    }

    $stmt->close();

    return $users;
}

// Function to update user role
function updateUserRole($user_id, $new_role, $conn) {
    // Fetch the previous role
    $stmt = $conn->prepare("SELECT user_role FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($previous_role);

    if ($stmt->fetch()) {
        // Update the user role
        $updateStmt = $conn->prepare("UPDATE users SET user_role = ? WHERE user_id = ?");
        $updateStmt->bind_param("si", $new_role, $user_id);
        $updateStmt->execute();
        $updateStmt->close();

        // Log the role change
        logRoleChange($user_id, $previous_role, $new_role, $_SESSION['username'], $conn);
    }

    $stmt->close();
}

// Function to log role change
function logRoleChange($user_id, $previous_role, $new_role, $changed_by, $conn) {
    $stmt = $conn->prepare("INSERT INTO role_change_history (user_id, previous_role, new_role, changed_by) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $previous_role, $new_role, $changed_by);
    $stmt->execute();
    $stmt->close();
}

// Function to report an issue


// Function to delete an issue
function deleteIssue($issueId, $conn) {
    $stmt = $conn->prepare("DELETE FROM reported_issues WHERE issue_id = ?");
    $stmt->bind_param("i", $issueId);
    $stmt->execute();
    $stmt->close();
}

// Function to resolve an issue
function resolveIssue($issueId, $conn) {
    $stmt = $conn->prepare("UPDATE reported_issues SET is_resolved = 1 WHERE issue_id = ?");
    $stmt->bind_param("i", $issueId);
    $stmt->execute();
    $stmt->close();
}

// Function to fetch tracked repositories

// Function to add a repository
function addRepository($repoName, $repoUrl, $conn) {
    $stmt = $conn->prepare("INSERT INTO tracked_repositories (repository_name, repository_url) VALUES (?, ?)");
    $stmt->bind_param("ss", $repoName, $repoUrl);
    $stmt->execute();
    $stmt->close();
}

// Function to fetch repository details

// Function to update a repository
function updateRepository($repoId, $repoName, $repoUrl, $conn) {
    $stmt = $conn->prepare("UPDATE tracked_repositories SET repository_name = ?, repository_url = ? WHERE repository_id = ?");
    $stmt->bind_param("ssi", $repoName, $repoUrl, $repoId);
    $stmt->execute();
    $stmt->close();
}

// Function to delete a repository
function deleteRepository($repoId, $conn) {
    $stmt = $conn->prepare("DELETE FROM tracked_repositories WHERE repository_id = ?");
    $stmt->bind_param("i", $repoId);
    $stmt->execute();
    $stmt->close();
}
?>
