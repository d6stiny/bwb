<?php
require_once 'controllers/Auth.php';
require_once 'models/Bottle.php';

$auth = new AuthController();
$user = $auth->getCurrentUser();

// Get user's bottles
$bottles = $auth->getBottles($user['id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="./public/css/globals.css" />
    <link rel="stylesheet" href="./public/css/bottles.css" />

    <title>Dashboard - BWB</title>
</head>

<body>
    <section class="container">
        <nav>
            <a href="/logout" class="button secondary ml-auto w-fit">
                <img src="./public/images/logout-icon.svg" class="size-4" />
                Log Out
            </a>
        </nav>

        <div>
            <h1>Your Bottles</h1>

            <div class="bottles-grid mt-7">
                <button class="button add-bottle border-dashed">+ Add Bottle</button>
                <?php foreach ($bottles as $bottle): ?>
                    <a href="/bottles/<?php echo htmlspecialchars($bottle['id']); ?>" class="button bottle border">
                        <?php echo htmlspecialchars($bottle['name']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</body>

</html>