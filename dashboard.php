<?php
require_once 'controllers/Auth.php';
require_once 'models/Bottle.php';
require_once 'partials/Head.php';
require_once 'helpers.php';
require_once 'partials/Footer.php';

$auth = new AuthController();
$user = $auth->getCurrentUser();

// Get user's bottles
$bottles = $auth->getBottles($user['id']);

// Render the header partial with custom title
renderHead("Dashboard - BWB");
?>

<section class="container">
    <nav>
        <a href="/logout" class="button secondary ml-auto w-fit">
            <img src="<?php echo asset('images/logout-icon.svg'); ?>" class="size-4" /> Log Out
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

<?php
// Render the footer partial
renderFooter();
?>