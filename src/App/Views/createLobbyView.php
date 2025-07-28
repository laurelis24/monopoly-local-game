<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create lobby</title>
</head>
<body>
    <h1>Create lobby</h1>

    <form  action="/lobby/create" method="post">
         <input type="hidden" name="token"  value="<?= $_SESSION['token']; ?>">
        <label for="name">Name:</label>
        <br>
        <input id="name" name="name" type="text" required>
        <br>
         <label for="password">Password:</label>
         <br>
        <input id="password"  name="password" type="password" required>
        <br>
        <label for="start-money">Start money:</label>
         <br>
        <input id="start-money"  name="start_money" type="number" min="150" max="500" value="150" required>
        <br>
        <button type="submit" >Create</button>
    </form>
</body>
</html>