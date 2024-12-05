<?php
require_once 'partials/Footer.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="./css/home.css">

    <link rel="icon" href="./assets/logo.svg" />

    <title>Brainy Water Bottle</title>
</head>

<body>
    <header class="main-header">
        <div class="header-container">
            <a href="./index">
                <img class="logo" src="./assets/logo.svg" alt="Brainy Water Bottle logo" />
            </a>

            <nav class="header-links">
                <a href="./learnmore">Learn More</a>
                <a href="./feedback">Feedback</a>
            </nav>
        </div>
    </header>
    <div class="container">
        <section class="hero">
            <h1 class="hero-title">Hydrate Your Future</h1>
            <p class="hero-description">
                The Brainy Water Bottle (BWB) is a smart bottle that measures water
                temperature hourly or throughout the day, bringing innovation and
                technology closer to your hydration routine.
            </p>

            <div class="hero-btns">
                <a href="./login" class="btn-primary">Try Now</a>
                <a href="./learnmore" class="btn-secondary">Learn More</a>
            </div>

            <img class="hero-img" src="./images/example_bottles.jpg" alt="Two modern thermos bottles" />
        </section>

        <section class="features">
            <h2 class="features-title">Features</h2>

            <div class="features-grid">
                <div class="feature">
                    <strong>Temperature Monitoring</strong>
                    <p>
                        Displays water temperature to ensure you know the best places to
                        store it.
                    </p>
                </div>

                <div class="feature">
                    <strong>Modern and Portable Design</strong>
                    <p>
                        Stylish, easy-to-carry design that fits perfectly into any
                        lifestyle.
                    </p>
                </div>

                <div class="feature">
                    <strong>Liquid Level</strong>
                    <p>
                        Displays the liquid level of your bottle, so you know when you
                        need to refill.
                    </p>
                </div>

                <div class="feature">
                    <strong>Health Benefits</strong>
                    <p>
                        Staying hydrated is essential for health, and the BWB makes it
                        easier and more enjoyable.
                    </p>
                </div>
            </div>
        </section>
    </div>

    <?php
    renderFooter();
    ?>
</body>

</html>