<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
   <form method="POST" action="/register">
  <input type="text" name="username" placeholder="Username" required><br>
    <?php if (!empty($_SESSION['usernameError'])) : ?>
     
     <p>
      <?php
        echo $_SESSION['usernameError'];
        ?>
     </p>
    <?php endif; ?>
  <input type="password" name="password" placeholder="Password" required><br>
  <button type="submit">Register</button>
</form>
</body>
</html>