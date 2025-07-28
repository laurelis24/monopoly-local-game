<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
  <form method="POST" action="/login">
  <input name="username" required>
  <input type="password" name="password" required>

   <?php if (isset($error)): ?>
     
     <p>
      <?php echo $error; ?>
     </p>
    <?php endif; ?>
  <button type="submit">Login</button>
</form>
</body>
</html>