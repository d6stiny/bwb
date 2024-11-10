<?php
require_once 'controllers/Auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $auth = new AuthController();
    
    try {
        $auth->register($email, $password);
        // Will be redirected by AuthController if successful
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - BWB</title>
</head>
<body>
    <header class="cabecalho">
        <a href="index.html" class="link_back"><button class="but_back">Go to Home Page</button></a>
        <h1>Sign Up</h1>
    </header>
    <?php if (isset($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form id="signupForm" method="POST">
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Sign Up</button>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
    <br><br><br>
    <a href="homeaccount.html"><button>Go to your bottles (Debug only)</button></a>
</body>
</html>