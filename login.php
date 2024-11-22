<?php
require_once 'controllers/Auth.php';
require_once 'helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $auth = new AuthController();

    try {
        $auth->login($email, $password);
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
    <title>Log In</title>

    <?php echo style('css/globals.css'); ?>
    <?php echo style('css/login.css'); ?>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600&display=swap" rel="stylesheet" />
</head>

<body>
    <div class="login-container">
        <h1>Log In</h1>

        <form method="POST">
            <div class="input-container">
                <input type="email" name="email" placeholder="E-mail" required />
                <input type="password" name="password" placeholder="Password" required />
            </div>

            <button type="submit" class="primary">Log In</button>
        </form>

        <div class="separator">
            <hr />
            <span>OR</span>
            <hr />
        </div>

        <p>Don't have an account? <a href="./signup">Sign Up</a></p>
    </div>
</body>

</html>