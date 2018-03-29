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
        
        <select name="char">
            <option value='Char1'>Char 1</option>
            <option value='Char2'>Char 2</option>
            <option value='Char3'>Char 3</option>
        </select>
        
        <input type="submit" value="Done">
    </form>
</body>
</html>