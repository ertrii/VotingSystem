<?php
/*
    Voting System
*/
//Config DataBase

const VOTING_SYSTEM                     =           true;               // on / off

const VOTE_INFO                         =           (VOTING_SYSTEM) ? 'try the new voting system' : 'voting system in maintenance...';
//HOST
const HOST                              =           'localhost';

//USER DATABASE
const DB_USER                           =           'root';
const DB_PASS                           =           '';

//DATABASE VOTE
const DB_VOTE                           =           'vote';
//DATABASE MAPLE
const DB_MAPLE                          =           'maple_maplelife';  //Example

const SESSION_VARIABLE                  =           'id';               //Example, $_SESSION[SESSION_VARIABLE] == $_SESSION['id']
//System
const TIMEZONE                          =           'America/Lima';     //http://php.net/manual/es/timezones.php
const TIMEFORTHENEXTVOTE                =           1;                //hours
const IPCONTROL                         =           true;
const MIN_LV_REQUERID                   =           15;
//const VERIFY

const ADDITIONAL_VOTE                   =           true;               //(int), accumulate(c)

//System Vote
const VOTE_LINK                         =           'http://www.gtop100.com/topsites/MapleStory/sitedetails/MapleRoyals-The-Nostalgic-MapleStory-Server-79510?vote=1';

const RANK_TABLE_ROWS                   =           5;//int
const RANK_TABLE_COL_START_DATE         =           true;//boilean
const RANK_TABLE_COL_VOTE_ADDITIONAL    =           false;//boolean

const MAX_INPUT_CHARS                   =           12;

class Message{
    
    public const SUCCESSFUL_VOTE = '<p class="v-success">Thank you for the Vote.</p>'; //line 85 vote.php    
    public const DONTWINITEMS = '<p class="v-info">Sorry you did not win, try it on the next vote f7.</p>';
    public const CANTVOTE = '<p class="v-info">You can not vote until you complete '. TIMEFORTHENEXTVOTE .' hours.</p>';
    public const CANTVOTE_BYIP = '<p class="v-info">You can not vote here until you complete '. TIMEFORTHENEXTVOTE .' hours.</p>';
    public const VOTE_NOTICE = '<p class="v-alert">You will be directed to gtop100 in <span id="v-count_time">5</span> seconds...</p>';//line 108 and check line 88
    public const INPUT_TEXT_NULL = '<p class="v-info">Please, write your username<p>';//line 61 security.php, check line 47 and 55 script.js
    public const SELECT_CHAR = '<p class="v-info">Please, select your character<p>';
    public const USER_DONT_EXIST = '<p class="v-alert">This is user is not exists<p>';
    public const PLAY_THE_GAME_FIRST = '<p class="v-info">Please login firts in the game...<p>';
    public const MIN_LV_REQUERID = '<p class="v-info">You need a character as a minimum level ' . MIN_LV_REQUERID . ' <p>';
    public const DONT_HAVE_CHAR = '<p class="v-info">You dont have a character in the game, please create one</p>';
    public const DEFAULT_CHAR_DONE = '<p class="v-info">Done...</p>';
    public const SECURITY_WARNING = '<p class="v-warning">We found a strange behavior</p>';
}

class Items{

    private const PRIZE_1  = array(
        'status'        =>      true,
        'type'          =>      'continuous',//there are three types: continuos(c), requerid(r), accumulate(a)
        'quantity'      =>      [
            3,
            array('min' => 1, 'max' => 1),
            5
        ],
        'voteRequerid'  =>      [1, 100, 50, 100, 250, 500, 1000],
        
        'item'          =>      array(
    
            'id'            =>      84565465,
            'name'          =>      'gachapom',
            'img'           =>      'gacha.png'
    
        )
            
    );

    private const PRIZE_2 = array(
        'status'        =>      true,
        'type'          =>      'requerid',
        'quantity'      =>      [1, 5],        
        'voteRequerid'  =>      [9, 50, 100, 198, 500, 1000],
        'item'          =>      array(
    
            'id'            =>      123456789,
            'name'          =>      'medall',
            'img'           =>      'medall.jpg'
    
        )
    
    );

    private const ADDITIONAL_PRIZE = array(
        'status'        =>      false,
        'type'          =>      'accumulate',
        'quantity'      =>      2,        
        'voteRequerid'  =>      [17, 50, 100, 250, 500, 1000],
        'item'          =>      array(
    
            'id'            =>      15510987,
            'name'          =>      'weapom',
            'img'           =>      'img.jpg'
    
        )
    
    );
    //you can create new items
    public static function get(){
        return [self::PRIZE_1, self::PRIZE_2, self::ADDITIONAL_PRIZE];
    }
    
}

session_start();