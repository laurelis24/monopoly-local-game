<?php
use App\Session\Session;

$title = 'Login'
?>

  <h1>Login</h1>
    <a href="/register">Register</a>
  <form method="POST" action="/login">
  <input type="text" name="username" required>
  <input type="password" name="password" required>


 <?php if (Session::getError('wrongUsernameOrPassword')) : ?>
        <p class="input-error"><?=Session::getError('wrongUsernameOrPassword')?></p>
  <?php endif ?>
  <button type="submit">Login</button>
</form>
