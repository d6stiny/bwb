<?php
require_once 'controllers/Auth.php';
require_once 'helpers.php';

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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up</title>

    <?php echo style('css/globals.css'); ?>
    <?php echo style('css/signup.css'); ?>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600&display=swap" rel="stylesheet" />
</head>

<body>
    <div class="signup-container">
        <h1>Sign Up</h1>

        <form method="POST">
            <div class="input-container">
                <input type="email" name="email" placeholder="E-mail" required />
                <input type="password" name="password" placeholder="Password" required />
                <input type="password" name="password" placeholder="Confirm the password" required />
            </div>

            <button type="submit" class="primary">Sign Up</button>
        </form>

        <div class="separator">
            <hr />
            <span>OR</span>
            <hr />
        </div>

        <p>Already have an account? <a href="./login">Log In</a></p>
    </div>
</body>

</html>