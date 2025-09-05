<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title><?= htmlspecialchars($title ?? 'Untitled') ?></title>
      <script src="../../../js/javascript.js" defer></script>
    <link rel="stylesheet" href="../../../css/style.css">
</head>
<body>
    <?= $content ?>
</body>
</html>