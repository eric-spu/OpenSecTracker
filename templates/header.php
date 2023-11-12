<?php
// templates/header.php - Updated Header template

echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>' . SITE_NAME . '</title>
</head>
<body>

<header>
    <nav>
        <span id="menu-toggle">&#9776; Menu</span>
        <ul id="menu-list">
            <li><a href="index.php">Home</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="admin_dashboard.php">Admin Dashboard</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        </ul>
    </nav>
</header>';
?>
