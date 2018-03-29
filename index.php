<?php
include_once('vote.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Voting System</title>
</head>
<body>
    <form action="post">
        <input type="text" name="user" id="" placeholder="User">
        <input type="submit" value="Vote">
    </form>
    <br>
    <form action="post">
        <input type="text" name="char" placeholder="Character">
        <input type="submit" value="Done">
    </form>
</body>
</html>