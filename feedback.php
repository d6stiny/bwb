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
        <form method="get" class="form" id="feedback-form">
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