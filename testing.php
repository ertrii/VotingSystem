<?php
include_once "vote.php";

$v = new Vote();
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
        }
        .logo img{
            max-width: 150px;
            display: block;
        }

        main{
            max-width: 750px;
            display: flex;
            margin-left: auto;
            margin-right: auto;            
        }
        .col1, .col2{
            width: 50%;
            padding: 2.5em 0;            
        }
        .col2{
            display: flex;
            justify-content: flex-end;
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
        }
        input[type="submit"]{
            background-color: #FED42A;
        }
        .col2 #formVote{
            margin-bottom: 1em;
        }
        
        .col2 p{
            font-family: sans-serif;
            padding-bottom: 5px;            
        }
        .col2 .v-not_win_items{
            color: #F5532C;
            font-size: 10pt;
        }
        .col2 .v-thanks_for_vote{            
            font-weight: bold;
            color: #FED42A;
            font-size: 12pt;
        }
        .col2 .v-total_votes{
            font-size: 9pt;
        }
        .col2 .v-sub_title_items{
            padding-top: 5px;            
        }
        .col2 .v-list_items{            
            padding-left: 17px;
        }
        .col2 .v-vote_notice{
            padding-top: 5px;
            font-size: 9pt;
        }

        .col2 .v-default_char{
            padding-top: 1.5em;
            font-size: 10pt;
        }
        .col2 .v-vote_notice{
            font-size: 9pt;
        }
        .col2 .v-config_notice{
            font-size: 11pt;
            color: #F5532C;
        }
        .col2 .v-remaining_time{
            font-size: 9pt;
            color: #F5532C;
        }
        select{
            width: 100%;            
            background-color: #f1f1f1;
            padding: 7px 5px;
            border: none;
            margin-bottom: 5px;
        }
        .v-config_done{
            padding-top: 2px;
            font-size: 9pt;
        }
        footer{
            text-align: center;            
        }
    </style>
</head>
<body>
<!-- Print form_Vote -->
    <div class="container">
    <nav>
        <div class="navbar">
            <div class="logo"><img src="https://mapleroyals.com/logo.png" alt=""></div>
            <div class="list">
                <ul>
                   <li><a href="">SESSION</a></li>
                   <li><a href="">AUTOR</a></li>
                </ul>
            </div>
        </div>
        
    </nav>
    <main>
        <div class="col1">
            <h1>Welcome</h1>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eos, vero? Doloremque odit dolorem voluptas nulla harum ducimus quae iusto vero, animi impedit, earum, recusandae molestiae est laudantium aliquid asperiores ipsam!</p>
        </div>
        <div class="col2">
            <div class="forms">
            <?= $v -> getForm_Vote()?>
            <?= $v -> info['formVote']['text'] ?>
            <!--  if there is a session, print form_Config  -->    
            <?= $v -> getForm_Config()?>
            <?= $v -> info['formConfig']['text'] ?>
            </div>
            
        </div>
    </main>
    <footer>
        <p>All right reserved. Voting System by Churano</p>
    </footer>
    </div>
    

    <script src="script.js"></script>    
</body>
</html>