<?php
include_once 'vote.php';
$vote = new Vote();
$rank = $vote -> ranking();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Template: Vote</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">    
</head>
<body>
<!-- Form Vote  -->
<?= $vote->getFormVote() ?>
<?= $vote->info['formVote'] ?>




<!--  From Config,, if there is a session -->
<?= $vote->getFormConfig() ?>
<?= $vote->info['formConfig'] ?>




<?php
    //if there is a session
    echo $rank['user'];


    //Table Ranking
    echo $rank['table'];
?>


<!-- script -->
<script src="script.js"></script>
</body>
</html>