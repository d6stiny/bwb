<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $webhook = 'https://discord.com/api/webhooks/1310564546850586634/DSzlWN-boRLcO-sI6ohLxJIkqdCHpT4m9GmN03vcc8VBRDFaZ74TPS29jrnU1sjphfCV';
    $data = [
        'content' => null,
        'embeds' => [
            [
                'title' => '❗ New Feedback',
                'description' => '‎',
                'color' => 5297151,
                'fields' => [
                    [
                        'name' => ':adult: Name',
                        'value' => $_POST['name'] ?? 'N/A',
                        'inline' => true
                    ],
                    [
                        'name' => ':e_mail: Email',
                        'value' => $_POST['email'] ?? 'N/A',
                        'inline' => true
                    ],
                    [
                        'name' => ':droplet: Bottle Id',
                        'value' => '`' . ($_POST['bottle-id'] ?? 'N/A') . '`',
                        'inline' => true
                    ],
                    [
                        'name' => '‎',
                        'value' => '‎',
                    ],
                    [
                        'name' => ':page_with_curl: Feedback',
                        'value' => $_POST['feedback'] ?? '',
                    ],
                    [
                        'name' => '‎',
                        'value' => '‎',
                    ],
                ],
                'timestamp' => date(format: 'c'),
            ],
        ],
    ];

    $jsonData = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    // Send POST request using cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $webhook);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    // Enable response capture
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    // Check for cURL errors
    if ($response === false) {
        $error = curl_error($ch);
        echo "cURL Error: $error";
    } else {
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode >= 400) {
            echo "HTTP Error: $httpCode Response: $response";
        } else {
            header("Location: /thanksfeedback");
        }
    }

    curl_close($ch);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="/css/globals.css">
    <link rel="stylesheet" href="/css/feedback.css">

    <link rel="icon" href="./assets/logo.svg" />

    <script src="./js/feedback.js" defer></script>

    <title>Feedback</title>
</head>

<body>
    <section class="container">
        <h1>Feedback</h1>
        <form method="post" class="form" id="feedback-form">
            <div class="inputs">
                <div class="input-container">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" placeholder="Name" required />
                    <p class="form-error" id="name-error"></p>
                </div>

                <div class="input-container">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email" required />
                    <p class="form-error" id="email-error"></p>
                </div>

                <div class="input-container">
                    <label for="bottle-id">Bottle Id</label>
                    <input type="text" name="bottle-id" id="bottle-id" placeholder="Bottle Id" required />
                    <p class="form-error" id="bottle-id-error"></p>
                </div>

                <div class="input-container">
                    <label for="feedback">Tell us what you think</label>
                    <textarea name="feedback" id="feedback" placeholder="Tell us what you think..." required></textarea>
                    <p class="form-error" id="feedback-error"></p>
                </div>
            </div>

            <div class="form-actions">
                <button class="btn-primary" type="submit">Send Feedback</button>
                <a href="./index" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </section>
</body>

</html>