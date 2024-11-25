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
$bottle_level = $bottleModel->getLevel($bottleId);
$temperatures = $bottleModel->getTemperatures($bottleId);
$status = $statusModel->getCurrentStatus($bottleId);

// Format temperature data for the chart
$temperature_data = array_map(function ($temp) {
    return [
        'created_at' => $temp['measured_at'],
        'temp' => floatval($temp['value'])
    ];
}, $temperatures);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <?= style('bottle') ?>

    <link rel="icon" href="./assets/logo.svg" />

    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="./js/delete-bottle-dialog.js" defer></script>

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

        <h1>Bottle 1</h1>

        <div class="informations-grid">
            <div class="information">
                <div class="information-water-level">
                    <i data-lucide="milk"></i>

                    <div class="water-level">
                        <strong>74%</strong>
                        <span>Level</span>
                    </div>
                </div>

                <div class="level-bar">
                    <div class="bar" style="height: 74%"></div>
                    <span class="current-level">74%</span>
                </div>
            </div>

            <div class="information">
                <div class="information-temperature">
                    <i data-lucide="flame">Icon</i>

                    <div class="temperature">
                        <strong>18 °C</strong>
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
            <button class="delete-bottle-btn btn-destructive" id="open-delete-bottle-dialog-btn">
                <i data-lucide="trash-2"></i>
                Delete Bottle
            </button>
        </footer>

        <div class="dialog" id="delete-bottle-dialog">
            <div class="dialog-content">
                <div class="dialog-header">
                    <h2>Delete Bottle</h2>
                    <button class="dialog-close-btn" id="close-delete-bottle-dialog">
                        <i data-lucide="x"></i>
                    </button>
                </div>

                <form method="get" class="form" id="delete-bottle-form">
                    <div class="inputs">
                        <div class="input-container">
                            <label for="bottle-name">To confirm, type "Bottle 1" in the box below</label>
                            <input type="text" name="bottle-name" id="bottle-name"
                                placeholder="To confirm, type &quot;Bottle 1&quot;" required />
                            <p class="form-error" id="bottle-name-error"></p>
                        </div>
                    </div>

                    <button type="submit" class="btn-destructive">Delete Bottle</button>
                </form>
            </div>
    </section>

    <script>
        lucide.createIcons();

        const ctx = document
            .getElementById("bottle-temperature-chart")
            .getContext("2d");

        const hours = Array.from({ length: 25 }, (_, i) => i);
        const temperatures = [
            12, 12.3, 12.2, 12.1, 12.4, 12.5, 12.7, 12.6, 13, 13.2, 13.3, 13.3,
            13.4, 13.2, 13.6, 13.7, 13.4, 13.3, 13.2, 12, 11.9, 11.8, 11.9, 11.7,
            11.6,
        ];

        new Chart(ctx, {
            type: "line",
            data: {
                labels: hours.map((h) => h.toString().padStart(2, "0") + ":00"),
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
                            callback: function (value, index, values) {
                                if (index % 6 === 0) return this.getLabelForValue(value);
                                return "";
                            },
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
</body>

</html>