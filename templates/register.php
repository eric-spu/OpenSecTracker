<?php
// templates/register.php - Registration form

echo '<div class="container">
    <h1>Register</h1>
    <form method="post" action="register.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Register</button>
    </form>
</div>';
?>
