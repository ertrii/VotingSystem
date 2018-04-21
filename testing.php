<?php
include_once "VotingSystem/vote.php";

$v = new Vote();
$rank = $v -> ranking();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Testing Vote</title>    
    <style>
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body{
            width: 100%;            
            background-color: #f1f1f1;
            color: #555;
        }
        .container{            
            min-height: 100vh;
            width: 100%;
        }
        span{
            color: #FED42A;
            background-color: #403E3E;
            padding: 2px 5px;
        }
        nav{
            width: 100%;            
            background-color: #fff;
        }
        .navbar{
            width: 100%;
            margin-left: auto;
            margin-right: auto;
            max-width: 750px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 65px;
        }

        .navbar .list ul{
            display: flex;
            list-style: none;
        }
        .navbar .list ul li{
            margin-left: 5px;            
        }
        .navbar .list ul li a{
            text-decoration: none;
            color: #555;
            font-weight: bold;
            font-size: 12px;
            font-family: sans-serif;
        }
        .logo a{
            font-size: 16pt;
            text-decoration: none;
            color: #FED42A;
            font-weight: bold;            
        }        

        main{
            max-width: 750px;
            display: flex;
            margin-left: auto;
            margin-right: auto;            
            flex-wrap: wrap;
        }
        .col1, .col2{
            width: 50%;
            padding: 2.5em 0;            
        }
        .col3{
            width: 100%;
            margin-bottom: 35px;
        }
        .v-user_ranking{
            font-size: 9pt;            
            font-family: sans-serif;
        }
        .v-ranking_table{
            background-color: white;
            padding: 15px;
            box-shadow: 0px 1px 5px -3px black;
            width: 100%;
            text-align: left;            
        }
        .v-ranking_table td{
            padding: 3px 5px;
            font-size: 9pt;
        }
        .v-ranking_table tr:nth-child(even){
            background-color: #FED42A;            
        }
        .col1 h1{
            font-family: sans-serif;
            padding-bottom: 10px;
        }
        .col1 h2{
            padding-top: 15px;
            font-size: 14pt;
        }        
        .col1 ul{
            padding: 15px 0 0 15px;
            font-size: 9pt;
            font-family: sans-serif;
        }
        .col1 ul li{
            padding-bottom: 5px;
        }
        .col2{
            display: flex;
            justify-content: flex-end;
            align-items: flex-start;
        }
        .col2 .forms{
            display: flex;
            max-width: 250px;
            background-color: white;
            flex-direction: column;
            box-shadow: 0px 1px 5px -3px black;
            padding: 2em 1em;
        }
        input{
            border: none;
            padding: 7px 5px;
            width: 100%;        
        }
        input[type="text"]{
            text-align: center;            
            background-color: #f1f1f1;
            margin-bottom: 5px;
        }
        input[type="submit"]{
            background-color: #FED42A;
            cursor: pointer;
        }        
        
        .col2 p{
            font-family: sans-serif;
            padding-bottom: 5px;            
        }
        .v-info{
            font-size: 9pt;
            color: steelblue;
            padding-top: 2px;
            text-align: center;
        }        
        .v-success{
            font-weight: bold;
            color: #FED42A;
            font-size: 12pt;
        }
        .v-danger{
            color: red;
        }
        .v-alert{
            padding-top: 5px;
            font-size: 9pt;
        }
        .v-warning{
            font-size: 9pt;
            color: #F5532C;
        }

        .v-sub_title_items{
            padding-top: 5px;            
        }
        .v-list_items{            
            padding-left: 17px;
        }

        .v-default_char{
            padding-top: 1.5em;
            font-size: 10pt;
        }                
        select{
            width: 100%;            
            background-color: #f1f1f1;
            padding: 7px 5px;
            border: none;
            margin-bottom: 5px;
        }        
        footer{
            text-align: center;
            padding-bottom: 25px;
        }

                @media(max-width: 750px){
            
            nav,main{
                padding: 0 25px;
            }
        }
        @media(max-width: 550px){
            .col1, .col2{
                width: 100%;
            }
            .col2{
                justify-content: center;
            }
        }
    </style>
</head>
<body>
<!-- Print form_Vote -->
    <div class="container">
    <nav>
        <div class="navbar">
            <div class="logo"><a href="index.html">VOTING SYSTEM</a></div>
            <div class="list">
                <ul>
                   <li><a href="https://github.com/ertrii" target="_blank">GITHUB</a></li>
                   <li><a href="https://twitter.com/ertrii" target= "_blank">TWITTER</a></li>
                </ul>
            </div>
        </div>
        
    </nav>
    <main>
        <div class="col1">
            <h1>Welcome</h1>            
            <p>This site is to test the voting system and verify that everything is fine. Edit the config.php file to configure...</p>
            <h2>Default Settings:</h2>
            <ul>
                <li>Voting System: <span><?=(VOTING_SYSTEM) ? 'on' : 'off'?></span></li>
                <li>Session Requerid: <span><?=(SESSION_REQUERID) ? 'enabled' : 'disabled'?></span></li>
                <li>There Session?: <span><?=(isset($_SESSION[SESSION_VARIABLE])) ? 'yes' : 'no' ?></span></li>
                <li>Directory Item Image: <span><?=Items::DIRECTORY?></span></li>
                <li>TimeZone: <span><?=TIMEZONE?></span></li>
                <li>Time for the next vote: <span><?=(TIMEFORTHENEXTVOTE < 1)? 'disabled' : TIMEFORTHENEXTVOTE . ' hour(s)'?></span></li>
                <li>Ip Control: <span><?=(IPCONTROL)? 'enabled' : 'disabled'?></span></li>
                <li>Min Level Requerid: <span><?=MIN_LV_REQUERID?></span></li>
                <li>Additional Vote: <span><?=(ADDITIONAL_VOTE) ? 'enabled' : 'disabled'?></span></li>
                <li>Maximun Character Input: <span><?=MAX_CHARS_INPUT?></span></li>
                <li>Ranking Table Rows: <span><?=RANK_TABLE_ROWS?></span></li>
                <li>Ranking Table Column Vote Additional Start Date: <span><?=(RANK_TABLE_COL_START_DATE)? 'enabled' : 'disabled'?></span></li>
                <li>Ranking Table Column Vote Additional: <span><?=(RANK_TABLE_COL_VOTE_ADDITIONAL)? 'enabled' : 'disabled'?></span></li>                
            </ul>
        </div>
        <div class="col2">
            <div class="forms">
            <?= $v -> getFormVote()?>
            <?= $v -> info['formVote']?>
            <?= $v -> items ?>
            <!--  if there is a session, print form_Config  -->    
            <?= $v -> getFormConfig()?>
            <?= $v -> info['formConfig']?>
            </div>            
        </div>

        <div class="col3">
            <h2>Ranking: <?=$rank['user']?></h2>
            <?=$rank['table']?>
        </div>
    </main>
    <footer><p>Voting System by ertrii(Churano)</p></footer>
    </div>    
    <script src="VotingSystem/script.js"></script>
</body>
</html>