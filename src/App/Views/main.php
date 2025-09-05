
    <?php
     $title = 'Main'
    ?>
    <?php if ($isLoggedIn): ?>
     <a href="lobby/create">Create lobby</a>
     <a href="lobbies">Lobbies</a>
      
     
    <button id="btn-logout">Logout</button>
   
    <?php endif; ?>

     <?php if (!$isLoggedIn): ?>
           <a href="login">Login</a>
           <a href="register">Register</a>
    <?php endif; ?>
