<?php
use App\Session\Session;

$title = 'Register';
?>

<h1>Register</h1>
     <a href="/login">Login</a>
   <form method="POST" action="/register">
  <input value="<?= (Session::getParamFromArray('old', 'username') ? htmlspecialchars(Session::getParamFromArray('old', 'username')) : '')?>" type="text" name="username" placeholder="Username" required><br>
    <?php  if (Session::getError('username')) : ?>
        <p class="input-error"><?=Session::getError('username')?></p>
   
     <?php elseif (Session::getError('usernameExists')) : ?>
      <p class="input-error"><?=Session::getError('usernameExists')?></p>

    <?php endif ?>
  <input type="password" name="password" placeholder="Password" required><br>
  <?php if (Session::getError('password')) : ?>
        <p class="input-error"><?=Session::getError('password')?></p>
    <?php endif ?>
  <button type="submit">Register</button>
</form>

