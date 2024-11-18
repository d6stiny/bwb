<?php function renderHead($title = "BWB")
{ ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlspecialchars($title) ?></title>
        <link rel="stylesheet" href="/public/css/navbar.css">
        <link rel="stylesheet" href="/public/css/globals.css">
    </head>

    <body>
    <?php } ?>