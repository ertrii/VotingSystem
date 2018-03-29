<?php

//Session, testing
session_start();

$_SESSION['user'] = 'erick';


//Config DataBase

//HOST
define('HOST', 'localhost');

//DATABASE VOTE
define('DB_VOTE', 'vote');
define('VOTE_USER', 'root');
define('VOTE_PASS', '');


//DATABASE MAPLEROYALS
define('DB_ROYALS', 'mapleRoyals');  //Example
define('ROYALS_USER', 'root');
define('ROYALS_PASS', '');


//System Vote
define('VOTE_LINK', 'http://www.gtop100.com/topsites/MapleStory/sitedetails/MapleRoyals-The-Nostalgic-MapleStory-Server-79510?vote=1');
define('VOTING_SYSTEM', true);    // on / off

if(VOTING_SYSTEM){
//information for user:

    //Vote on
    $info = 'try the new voting system';
}else{
    //Vote off
    $info = 'voting system in maintenance';
}

define('VOTE_INFO', $info);