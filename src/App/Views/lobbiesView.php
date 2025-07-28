<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lobbies</title>
</head>

<body>
    <h1>Lobbies</h1>
    <?php
        print_r($lobbies);
    ?>
    <?php if (isset($lobbies) && count($lobbies) <= 0) : ?>


        <?php foreach ($lobbies as $lobby): ?>
            <div>
                <p>Lobby Name: <?= htmlspecialchars($lobby['name']) ?></p>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>
</body>

</html>