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
    
    <?php

    $vote = new Vote();
    // Print form_Vote
    echo $vote -> getForm_Vote();
    
    ?>
    
    <br>
    <!--  if there is a session, print form_Config  -->
    <?= $vote -> getForm_Config()?>

</body>

</html>