<?php
require_once 'controllers/Auth.php';
require_once 'models/Bottle.php';

$auth = new AuthController();
$user = $auth->getCurrentUser();

$bottleId = $_GET['id'] ?? null;
if (!$bottleId) {
    header('Location: /bwb/dashboard');
    exit;
}

$bottle = new Bottle();

// Get bottle details - using array access for user ID
$bottleDetails = $bottle->getById($bottleId, $user['id']);
if (!$bottleDetails) {
    header('Location: /bwb/dashboard');
    exit;
}

// Get temperature data
$temperatures = $bottle->getTemperatures($bottleId);

// Get latest temperature
$temperature = !empty($temperatures) ? floatval($temperatures[0]['value']) : 0;

// Get bottle level data
$bottle_level = $bottle->getLevel($bottleId) ?? 0;

// Format data for chart
$temperature_data = array_map(function ($temp) {
    return [
        'timestamp' => strtotime($temp['measured_at']) * 1000,
        'temperature' => floatval($temp['value'])
    ];
}, $temperatures);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bottle #<?php echo htmlspecialchars($bottleId); ?> - BWB</title>
    <style>
        :root {
            --background: #0a0d13;
            --card-background: #141619;
            --border-color: #30363d;
            --text-color: #ffffff;
            --text-muted: #6b7280;
            --green: #58cc02;
            --green-hover: #4caf00;
            --blue: #4cb5f9;
            --blue-hover: #3a91c5;
            --orange: #ff9600;
            --red: #ff4b4b;
            --red-hover: #e60000;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Arial", sans-serif;
            background-color: var(--background);
            color: var(--text-color);
            line-height: 1.6;
            padding: 24px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .btn {
            background-color: var(--green);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: var(--green-hover);
        }

        .btn-icon {
            width: 40px;
            height: 40px;
            padding: 0;
            justify-content: center;
        }

        .btn-secondary {
            background-color: #3c3f43;
        }

        .btn-secondary:hover {
            background-color: #4a4d51;
        }

        .btn-delete {
            background-color: var(--red);
            margin-left: auto;
        }

        .btn-delete:hover {
            background-color: var(--red-hover);
        }

        h1 {
            font-size: 24px;
            font-weight: 600;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .card {
            background-color: var(--card-background);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 16px;
        }

        .card-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card-icon {
            font-size: 24px;
        }

        .card-title {
            font-size: 24px;
            font-weight: bold;
        }

        .card-subtitle {
            color: var(--text-muted);
            font-size: 14px;
        }

        .level-indicator {
            background-color: var(--blue);
            color: white;
            padding: 4px 8px;
            border-radius: 8px;
            font-size: 14px;
            margin-left: auto;
        }

        .chart-container {
            height: 300px;
            position: relative;
        }

        .chart {
            width: 100%;
            height: 100%;
        }

        .chart-label {
            text-align: center;
            color: var(--text-muted);
            font-size: 14px;
            margin-top: 8px;
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <div style="display: flex; align-items: center; gap: 16px">
                <a href="/dashboard" class="btn btn-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                </a>
                <h1>Your bottle</h1>
            </div>
            <a href="/logout" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
                Log Out
            </a>
        </header>

        <div class="grid">
            <div class="card">
                <div class="card-content">
                    <div class="card-icon" style="color: var(--blue)">🍶</div>
                    <div>
                        <div class="card-title"><?php echo $bottle_level; ?>%</div>
                        <div class="card-subtitle">Level</div>
                    </div>
                    <div class="level-indicator"><?php echo $bottle_level; ?>%</div>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <div class="card-icon" style="color: var(--orange)">🔥</div>
                    <div>
                        <div class="card-title">
                            <?php echo $temperature; ?>
                            °C
                        </div>
                        <div class="card-subtitle">Temperature</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card chart-container">
            <canvas id="temperatureChart" class="chart"></canvas>
            <div class="chart-label">Temperature along the day</div>
        </div>

        <div style="margin-top: 24px">
            <form method="POST" style="display: inline"
                onsubmit="return confirm('Are you sure you want to delete this bottle?');">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="btn btn-delete">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 6h18" />
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                        <line x1="10" y1="11" x2="10" y2="17" />
                        <line x1="14" y1="11" x2="14" y2="17" />
                    </svg>
                    Delete Bottle
                </button>
            </form>
        </div>
    </div>

    <script>
        // Convert PHP data to JavaScript
        const data = <?php echo json_encode($temperature_data); ?>;

        // Function to draw the chart
        function drawChart() {
            const canvas = document.getElementById('temperatureChart');
            const ctx = canvas.getContext('2d');
            const width = canvas.width;
            const height = canvas.height;

            // Clear the canvas
            ctx.clearRect(0, 0, width, height);

            // Set chart styles
            ctx.strokeStyle = '#4cb5f9';
            ctx.lineWidth = 2;

            // Calculate scales
            const xScale = width / (data.length - 1);
            const yScale = height / (Math.max(...data.map(d => d.temp)) - Math.min(...data.map(d => d.temp)));

            // Draw the line
            ctx.beginPath();
            data.forEach((point, index) => {
                const x = index * xScale;
                const y = height - (point.temp - Math.min(...data.map(d => d.temp))) * yScale;
                if (index === 0) {
                    ctx.moveTo(x, y);
                } else {
                    ctx.lineTo(x, y);
                }
            });
            ctx.stroke();

            // Draw X-axis labels
            ctx.fillStyle = '#6b7280';
            ctx.font = '12px Arial';
            ctx.textAlign = 'center';
            data.forEach((point, index) => {
                const x = index * xScale;
                ctx.fillText(point.time, x, height - 10);
            });

            // Draw Y-axis labels
            ctx.textAlign = 'right';
            const yLabels = [Math.min(...data.map(d => d.temp)), Math.max(...data.map(d => d.temp))];
            yLabels.forEach((label, index) => {
                const y = height - index * (height - 20);
                ctx.fillText(`${label}°C`, 30, y);
            });
        }

        // Call drawChart when the window loads and resizes
        window.addEventListener('load', drawChart);
        window.addEventListener('resize', drawChart);
    </script>
</body>

</html>