<?php

//Session, testing
//session_start();

//$_SESSION['id'] = '2';


//Config DataBase

//HOST
define('HOST', 'localhost');

//USER DATABASE
define('DB_USER', 'root');
define('DB_PASS', '');



//DATABASE VOTE
define('DB_VOTE', 'vote'); 
//DATABASE MAPLEROYALS
define('DB_ROYALS', 'maple_maplelife');  //Example

define('MIN_LV_REQUERID', 15);

//System Vote
define('VOTE_LINK', 'http://www.gtop100.com/topsites/MapleStory/sitedetails/MapleRoyals-The-Nostalgic-MapleStory-Server-79510?vote=1');
define('VOTING_SYSTEM', true);    // on / off

if(VOTING_SYSTEM){
//information for user:

    //Vote on
    $info = 'try the new voting system';
}else{
    //Vote off
    $info = 'voting system in maintenance...';
}

define('VOTE_INFO', $info);