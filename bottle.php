<?php
require_once 'controllers/Auth.php';
require_once 'models/Bottle.php';
require_once 'models/Status.php';

$auth = new AuthController();
$user = $auth->getCurrentUser();
$bottleId = $_GET['id'] ?? null;

// Initialize models
$bottleModel = new Bottle();
$statusModel = new Status();

// Get bottle data
$bottle = $bottleModel->getById($bottleId);
$bottle_name = $bottle['name'] ?? 'Unnamed Bottle';
$bottle_level = $bottleModel->getLevel($bottleId);
$temperatures = $bottleModel->getTodaysTemperatures($bottleId);
$current_temperature = $bottleModel->getCurrentTemperature($bottleId);
$average_temperature = $bottleModel->getAverageTemperature($bottleId);

$temperaturesJson = json_encode($temperatures);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bottleModel->release($bottleId, $user['id']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="/css/globals.css">
    <link rel="stylesheet" href="/css/bottle.css">

    <link rel="icon" href="./assets/logo.svg" />

    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Bottle</title>
</head>

<body>
    <section class="container">
        <header>
            <a href="../dashboard" class="previous-btn btn-tertiary">
                <i data-lucide="chevron-left"></i>
            </a>
            <a href="../logout" class="logout-btn btn-secondary">
                <i data-lucide="log-out"></i>
                Log Out
            </a>
        </header>

        <h1><?= $bottle_name ?></h1>

        <div class="informations-grid">
            <div class="information">
                <div class="information-water-level">
                    <i data-lucide="milk"></i>

                    <div class="water-level">
                        <strong>
                            <?= $bottle_level ?>%
                        </strong>
                        <span>Level</span>
                    </div>
                </div>

                <div class="level-bar">
                    <div class="bar" style="height: <?= $bottle_level ?>%"></div>
                    <span class="current-level"><?= $bottle_level ?>%</span>
                </div>
            </div>

            <div class="information">
                <div class="information-temperature">
                    <i data-lucide="flame">Icon</i>

                    <div class="temperature">
                        <strong><?= htmlspecialchars($current_temperature) ?> °C (avg
                            <?= htmlspecialchars(number_format($average_temperature, 1)) ?> °C)</strong>
                        <span>Temperature</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="chart">
            <canvas id="bottle-temperature-chart"></canvas>

            <p>Temperature along the day</p>
        </div>

        <footer>
            <fieldset class="dangerous-fieldset bottle-actions-fieldset">
                <legend>Danger Zone</legend>
                <button class="rename-bottle-btn btn-secondary" id="open-rename-bottle-dialog-btn">
                    <i data-lucide="pencil-line"></i>
                    Rename Bottle
                </button>
                <button class="release-bottle-btn btn-destructive" id="open-release-bottle-dialog-btn">
                    <i data-lucide="circle-arrow-out-down-left"></i>
                    Release Bottle
                </button>
            </fieldset>
        </footer>

        <div class="dialog" id="release-bottle-dialog">
            <div class="dialog-content">
                <div class="dialog-header">
                    <h2>Release Bottle</h2>
                    <button class="dialog-close-btn" id="close-release-bottle-dialog">
                        <i data-lucide="x"></i>
                    </button>
                </div>

                <form method="post" class="form" id="release-bottle-form">
                    <div class="inputs">
                        <div class="input-container">
                            <label for="bottle-name">To confirm, type
                                "<strong><?= htmlspecialchars($bottle_name) ?></strong>" in the box below</label>
                            <input type="text" name="bottle-name" id="bottle-name"
                                placeholder="To confirm, type &quot;<?= htmlspecialchars($bottle_name) ?>&quot;"
                                required />
                            <p class="form-error" id="bottle-name-error"></p>
                        </div>
                    </div>

                    <button type="submit" class="btn-destructive">Release Bottle</button>
                </form>
            </div>
    </section>

    <script>
        lucide.createIcons();

        const temperaturesData = <?php echo $temperaturesJson; ?>;

        // Sort data chronologically
        const sortedData = temperaturesData.sort((a, b) =>
            new Date(a.measured_at) - new Date(b.measured_at)
        );

        const labels = sortedData.map(item => {
            const date = new Date(item.measured_at);
            return date.getHours().toString().padStart(2, '0') + ':00';
        });

        const temperatures = sortedData.map(item => item.value);

        const ctx = document.getElementById("bottle-temperature-chart").getContext("2d");

        new Chart(ctx, {
            type: "line",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Temperature",
                        data: temperatures,
                        borderColor: "#50D3FF",
                        backgroundColor: "rgba(80, 211, 255, 0.1)",
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2,
                        pointRadius: 0,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                    title: {
                        display: false,
                    },
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            color: "#A3AAAC",
                            maxRotation: 0,
                            font: {
                                size: 14, // Increased from default
                            },
                        },
                    },
                    y: {
                        grid: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            color: "#A3AAAC",
                            padding: 10,
                            callback: function (value, index, values) {
                                return value.toFixed(1) + "°";
                            },
                            font: {
                                size: 14, // Increased from default
                            },
                        },
                    },
                },
            },
        });
    </script>
    <script>
        // Pass PHP variables to JavaScript
        const bottleData = {
            id: <?= json_encode($bottleId) ?>,
            name: <?= json_encode($bottle_name) ?>
        };
    </script>
    <script src="/js/release-bottle-dialog.js"></script>
</body>

</html>