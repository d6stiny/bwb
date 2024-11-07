<?php
require_once 'controllers/Auth.php';

$auth = new AuthController();

// Store user data in variable
$user = $auth->getCurrentUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($user['email']); ?></h1>
        <a href="/logout.php">Logout</a>
    </header>
    <main>
        <h2>Your Dashboard</h2>
        <p>This is your personal dashboard area.</p>
        <div class="user-info">
            <p>User ID: <?php echo htmlspecialchars($user['id']); ?></p>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        </div>
    </main>
</body>
</html>