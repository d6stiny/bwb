<?php
require_once 'controllers/Auth.php';

$auth = new AuthController();

// Store user data in variable
$user = $auth->getCurrentUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Bottles</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', Arial, sans-serif;
            background-color: #0a0d13;
            color: white;
            margin: 0;
            padding: 0;
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
            margin: 0;
        }

        .logout-btn {
            background-color: #58cc02;
            color: white;
            font-weight: 700;
            font-size: 18px;
            padding: 12px 24px;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.15s ease-in-out;
            border-bottom: 4px solid #45a700;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-family: 'Nunito', Arial, sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .logout-btn:hover {
            background-color: #4caf00;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        .logout-btn:active {
            transform: translateY(4px);
            border-bottom: 0;
            box-shadow: inset 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .bottles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
        }

        .bottle-card {
            background-color: transparent;
            border: 1px solid #1f2937;
            border-radius: 8px;
            padding: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: border-color 0.3s ease;
        }

        .bottle-card:hover {
            border-color: #4b5563;
        }

        .add-bottle {
            border: 2px dashed #4b5563;
        }

        .add-bottle span {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #9ca3af;
        }

        .add-bottle:hover {
            border-color: #6b7280;
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
            background-color: #1f2937;
            padding: 24px;
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
        }

        .dialog h2 {
            margin-top: 0;
            margin-bottom: 16px;
        }

        .dialog-form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .dialog-form label {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .dialog-form input {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #4b5563;
            background-color: #374151;
            color: white;
        }

        .dialog-form button {
            padding: 8px 16px;
            background-color: #58cc02;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .dialog-form button:hover {
            background-color: #4caf00;
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
            <a href="/logout" class="logout-btn">Logout</a>
        </header>
        <div class="bottles-grid">
            <div class="bottle-card add-bottle" id="addBottleCard">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Add bottle
                </span>
            </div>
            <div class="bottle-card">
                <span>Bottle 1</span>
            </div>
            <div class="bottle-card">
                <span>Bottle 2</span>
            </div>
        </div>
    </div>

    <div id="addBottleDialog" class="dialog-overlay hidden" role="dialog" aria-labelledby="dialogTitle">
        <div class="dialog">
            <h2 id="dialogTitle">Add New Bottle</h2>
            <form id="addBottleForm" class="dialog-form">
                <label for="bottleId">
                    Bottle ID:
                    <input type="text" id="bottleId" name="bottleId" required>
                </label>
                <label for="bottleName">
                    Bottle Name:
                    <input type="text" id="bottleName" name="bottleName" required>
                </label>
                <button type="submit">Add Bottle</button>
            </form>
        </div>
    </div>

    <script>
        const addBottleCard = document.getElementById('addBottleCard');
        const addBottleDialog = document.getElementById('addBottleDialog');
        const addBottleForm = document.getElementById('addBottleForm');
        const bottlesGrid = document.querySelector('.bottles-grid');

        addBottleCard.addEventListener('click', () => {
            addBottleDialog.classList.remove('hidden');
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
            newBottleCard.innerHTML = `<span>${bottleName} (ID: ${bottleId})</span>`;

            bottlesGrid.appendChild(newBottleCard);

            addBottleDialog.classList.add('hidden');
            addBottleForm.reset();
        });
    </script>
</body>
</html>