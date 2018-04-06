<?php

//Session, testing
session_start();

$_SESSION['id'] = '2';

const WEB_DOMAIN = 'localhost';

define('VOTING_SYSTEM', true);    // on / off

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
const ADDITIONAL_VOTE = false;



class Items{

    private const PRIZE_1  = array(
        'status'        =>      true,
        'type'          =>      'continuous',
        'count'         =>      [
            array('min' => 0, 'max' => 1),
            array('min' => 1, 'max' => 1),
            array('min' => 1, 'max' => 3)
        ],
        'voteRequerid'  =>      [1, 10, 50, 100, 250, 500, 1000],
        
        'item'          =>      array(
    
            'id'            =>      84565465,
            'name'          =>      'gachapom',
            'img'           =>      'gacha.png'
    
        )
            
    );

    private const PRIZE_2 = array(
        'status'        =>      true,
        'count'         =>      1,
        'type'          =>      'requerid',
        'voteRequerid'  =>      [12, 50, 100, 250, 500, 1000],
        'item'          =>      array(
    
            'id'            =>      123456789,
            'name'          =>      'medall',
            'img'           =>      'medall.jpg'
    
        )
    
    );

    private const ADDITIONAL_PRIZE = array(
        'status'        =>      true,
        'count'         =>      2,
        'type'          =>      'accumulate',
        'voteRequerid'  =>      [10, 50, 100, 250, 500, 1000],
        'item'          =>      array(
    
            'id'            =>      15510987,
            'name'          =>      'weapom',
            'img'           =>      'img.jpg'
    
        )
    
    );

    public static function get(){
        return [self::PRIZE_1, self::PRIZE_2, self::ADDITIONAL_PRIZE];
    }
    
}

//System Vote
define('VOTE_LINK', 'http://www.gtop100.com/topsites/MapleStory/sitedetails/MapleRoyals-The-Nostalgic-MapleStory-Server-79510?vote=1');

if(VOTING_SYSTEM){
//information for user:

    //Vote on
    $info = 'try the new voting system';
}else{
    //Vote off
    $info = 'voting system in maintenance...';
}

define('VOTE_INFO', $info);