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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="/css/globals.css">
    <link rel="stylesheet" href="/css/signup.css">

    <link rel="icon" href="./assets/logo.svg" />

    <script src="./js/signup.js" defer></script>

    <title>Sign Up</title>
</head>

<body>
    <section class="container">
        <h1>Sign Up</h1>
        <form method="post" class="form" id="signup-form">
            <div class="inputs">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Email" required />
                <p class="form-error" id="email-error"></p>

                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" required />
                <p class="form-error" id="password-error"></p>

                <label for="password">Confirm the password</label>
                <input type="password" name="password" id="confirm-password" placeholder="Confirm the password"
                    required />
                <p class="form-error" id="confirm-password-error"></p>
            </div>

            <button class="btn-primary" type="submit">Sign Up</button>
        </form>

        <div class="divider">
            <hr />
            OR
            <hr />
        </div>

        <a class="cancel-btn btn-secondary" href="./index">Cancel</a>

        <p class="msg">
            Already have an account? <a href="./login">Log In</a>
        </p>
    </section>
</body>

</html>