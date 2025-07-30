<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lobbies</title>
</head>

<body>
    <h1>Lobbies</h1>
    <?php if (isset($lobbies) && count($lobbies) > 0): ?>


        <?php foreach ($lobbies as $lobby): ?>
            <div style="">
                <p>Lobby Name: <?= htmlspecialchars($lobby['name']) ?></p>
                <p>Host user: <?= htmlspecialchars($lobby['host_user']) ?></p>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>
</body>

</html>