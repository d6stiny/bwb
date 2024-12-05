<?php
require_once 'controllers/Auth.php';

$auth = new AuthController();

// Redirect if user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: /dashboard');
    exit;
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $auth = new AuthController();
    try {
        $auth->login($email, $password);
    } catch (Exception $e) {
        // Return JSON response for AJAX request
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
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
    <link rel="stylesheet" href="/css/login.css">

    <link rel="icon" href="./assets/logo.svg" />

    <script src="./js/login.js" defer></script>

    <title>Log In</title>
</head>

<body>
    <section class="container">
        <h1>Log In</h1>
        <form method="post" class="form" id="login-form">
            <div class="inputs">
                <div class="input-container">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email" required />
                    <p class="form-error" id="email-error"></p>
                </div>

                <div class="input-container">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password" required />
                    <p class="form-error" id="password-error"></p>
                </div>
            </div>

            <button class="btn-primary" type="submit">Log In</button>
        </form>

        <div class="divider">
            <hr />
            OR
            <hr />
        </div>

        <a class="cancel-btn btn-secondary" href="./index">Cancel</a>

        <p class="msg">
            Don't have an account? <a href="./signup">Sign Up</a>
        </p>
    </section>
</body>

</html>