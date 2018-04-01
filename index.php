<?php

include_once('vote.php');

$vote = new Vote();

if(isset($_POST['vote'])) $vote->start($_POST['user']);

if(isset($_POST['char'])) $vote -> defaultChar($_POST['char']);

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
    <!-- Print form_Vote -->
    <?= $vote -> getForm_Vote()?>

    <br>
    <?= $vote -> info['template'] ?>
    <!--  if there is a session, print form_Config  -->
    
    <?= $vote -> getForm_Config()?>

</body>

</html>