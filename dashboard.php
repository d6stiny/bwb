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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --background: #0a0d13;
            --dialog-background: #0d1117;
            --input-background: #141619;
            --border-color: #30363d;
            --text-color: #ffffff;
            --button-color: #4cb5f9;
            --button-hover: #3a91c5;
            --logout-button: #3c3f43;
            --logout-button-hover: #4a4d51;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Nunito', Arial, sans-serif;
            background-color: var(--background);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            justify-content: center;
        }

        .container {
            max-width: 1200px;
            width: 100%;
            padding: 24px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        h1 {
            font-size: 24px;
            font-weight: 600;
        }

        .logout-btn {
            background-color: #3c3f43;
            color: white;
            font-weight: 700;
            font-size: 15px;
            padding: 8px 16px;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.15s ease-in-out;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .logout-btn:hover {
            background-color: #4a4d51;
        }

        .logout-btn:active {
            transform: translateY(1px);
        }

        .bottles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
        }

        .bottle-card {
            background-color: transparent;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: border-color 0.3s ease;
        }

        .add-bottle {
            border: 2px dashed var(--border-color);
        }

        .add-bottle span {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #9ca3af;
        }

        .dialog-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .dialog {
            background-color: var(--dialog-background);
            border-radius: 24px;
            width: 100%;
            max-width: 400px;
            border: 1px solid var(--border-color);
            padding: 32px;
            position: relative;
        }

        .dialog-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .dialog-title {
            font-size: 32px;
            font-weight: 700;
            color: white;
        }

        .close-button {
            position: absolute;
            top: 32px;
            right: 32px;
            background: none;
            border: none;
            color: #6e7681;
            cursor: pointer;
            padding: 8px;
            transition: color 0.2s;
        }

        .close-button:hover {
            color: white;
        }

        .dialog-form {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .dialog-form input {
            width: 100%;
            padding: 16px 20px;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            background-color: var(--input-background);
            color: var(--text-color);
            font-size: 18px;
            font-weight: 600;
        }

        .dialog-form input:focus {
            outline: none;
            border-color: var(--button-color);
        }

        .dialog-form input::placeholder {
            color: white;
            opacity: 1;
        }

        .submit-button {
            background-color: var(--button-color);
            color: white;
            border: none;
            border-radius: 16px;
            padding: 16px;
            cursor: pointer;
            font-weight: 600;
            font-size: 18px;
            margin-top: 8px;
            transition: transform 0.2s, background-color 0.2s;
            border-bottom: 4px solid var(--button-hover);
        }

        .submit-button:hover {
            background-color: var(--button-hover);
        }

        .submit-button:active {
            transform: translateY(2px);
            border-bottom-width: 2px;
        }

        .hidden {
            display: none;
        }

        @media (max-width: 768px) {
            .bottles-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>Your bottles</h1>
            <button class="logout-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    style="margin-right: 8px;">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                Log Out
            </button>
        </header>
        <div class="bottles-grid">
            <div class="bottle-card add-bottle" id="addBottleCard">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Add bottle
                </span>
            </div>
            <?php foreach ($bottles as $bottle): ?>
                <a href="/bottles/<?php echo htmlspecialchars($bottle['id']); ?>" class="bottle-card">
                    <span>Bottle #<?php echo htmlspecialchars($bottle['id']); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <div id="addBottleDialog" class="dialog-overlay hidden" role="dialog" aria-labelledby="dialogTitle">
        <div class="dialog">
            <div class="dialog-header">
                <h2 id="dialogTitle" class="dialog-title">Add Bottle</h2>
                <button class="close-button" aria-label="Close dialog">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <form id="addBottleForm" class="dialog-form">
                <input type="text" id="bottleId" name="bottleId" placeholder="Bottle ID" required>
                <input type="text" id="bottleName" name="bottleName" placeholder="Bottle Name" required>
                <button type="submit" class="submit-button">Add Bottle</button>
            </form>
        </div>
    </div>

    <script>
        const addBottleCard = document.getElementById('addBottleCard');
        const addBottleDialog = document.getElementById('addBottleDialog');
        const addBottleForm = document.getElementById('addBottleForm');
        const closeButton = document.querySelector('.close-button');
        const bottlesGrid = document.querySelector('.bottles-grid');

        addBottleCard.addEventListener('click', () => {
            addBottleDialog.classList.remove('hidden');
        });

        closeButton.addEventListener('click', () => {
            addBottleDialog.classList.add('hidden');
        });

        addBottleDialog.addEventListener('click', (event) => {
            if (event.target === addBottleDialog) {
                addBottleDialog.classList.add('hidden');
            }
        });

        addBottleForm.addEventListener('submit', (event) => {
            event.preventDefault();
            const bottleId = document.getElementById('bottleId').value;
            const bottleName = document.getElementById('bottleName').value;

            const newBottleCard = document.createElement('div');
            newBottleCard.className = 'bottle-card';
            newBottleCard.innerHTML = `<span>${bottleName}</span>`;

            bottlesGrid.appendChild(newBottleCard);

            addBottleDialog.classList.add('hidden');
            addBottleForm.reset();
        });
    </script>
</body>

</html>