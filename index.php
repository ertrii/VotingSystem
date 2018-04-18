<?php
include_once('vote.php');
$vote = new Vote();
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
    <?= $vote -> getFormVote()?>
    <?= $vote -> info['formVote']?>
    <!--  if there is a session, print form_Config  -->    
    <?= $vote -> getFormConfig()?>
    <?= $vote -> info['formConfig']?>
    
    <script src="script.js"></script>
</body>
</html>