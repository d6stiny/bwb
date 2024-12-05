<?php
require_once 'controllers/Auth.php';
require_once 'models/Bottle.php';

/**
 * This script initializes the authentication controller and retrieves the current user.
 * It then creates an instance of the Bottle model and fetches the bottles associated with the current user.
 *
 * @var AuthController $auth The authentication controller instance.
 * @var array $user The current user's data.
 * @var Bottle $bottleModel The Bottle model instance.
 * @var array $bottles The list of bottles associated with the current user.
 */
$auth = new AuthController();
$user = $auth->getCurrentUser();
$bottleModel = new Bottle();
$bottles = $bottleModel->getUserBottles($user['id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="./css/dashboard.css">

    <link rel="icon" href="./assets/logo.svg" />

    <script src="./js/add-bottle-dialog.js" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <title>Dashboard</title>
</head>

<body>
    <section class="container">
        <header>
            <a href="./logout" class="logout-btn btn-secondary">
                <i data-lucide="log-out"></i>
                Log Out
            </a>
        </header>

        <h1>Your bottles</h1>

        <div class="bottles-grid">
            <button class="add-bottle-btn" id="open-add-bottle-dialog-btn">
                + Add bottle
            </button>
            <?php foreach ($bottles as $bottle): ?>
                <a href="./bottles/<?= htmlspecialchars($bottle['id']) ?>" class="bottle">
                    <?= htmlspecialchars($bottle['name'] ?? $bottle['id']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <div class="dialog" id="add-bottle-dialog">
        <div class="dialog-content">
            <div class="dialog-header">
                <h2>Add Bottle</h2>
                <button class="dialog-close-btn" id="close-add-bottle-dialog">
                    <i data-lucide="x"></i>
                </button>
            </div>

            <form method="post" class="form" id="add-bottle-form">
                <div class="inputs">
                    <div class="input-container">
                        <label for="bottleId">Bottle ID</label>
                        <input type="text" name="bottleId" id="bottleId" placeholder="Bottle Id" required />
                        <p class="form-error" id="bottleId-error"></p>
                    </div>

                    <div class="input-container">
                        <label for="bottleName">Bottle Name</label>
                        <input type="text" name="bottleName" id="bottleName" placeholder="Bottle Name" required />
                        <p class="form-error" id="bottleName-error"></p>
                    </div>
                </div>

                <button type="submit" class="btn-primary">Add Bottle</button>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>