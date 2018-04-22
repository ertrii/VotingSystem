<?php
session_start();// <--- remember this

//Voting System by ertrii

const VOTING_SYSTEM                     =           true;                                   //boolean, on / off

const SYSTEM_OFF                        =           'voting system in maintenance...';      //Msg
//HOST
const HOST                              =           'localhost';

//USER DATABASE
const DB_USER                           =           'root';
const DB_PASS                           =           '';

//DATABASE VOTING SYSTEM
const DB_VOTE                           =           'vote';                                 //System Database
//DATABASE MAPLE
const DB_MAPLE                          =           'maple_maplelife';                      //Example
//Sesion
const SESSION_REQUERID                  =           false;                                  //boolean
const SESSION_VARIABLE                  =           'id';                                   //string, Example: $_SESSION[SESSION_VARIABLE]
//zone
const TIMEZONE                          =           'America/Lima';                         //http://php.net/manual/es/timezones.php

const TIMEFORTHENEXTVOTE                =           1;                                      //hours
const MIN_LV_REQUERID                   =           15;
const IPCONTROL                         =           true;


const ADDITIONAL_VOTE                   =           false;                                   //(boolean), necessary for accumulate(c) type items

//topsites
const TOPSITE_URL                       =           'http://www.gtop100.com/topsites/MapleStory/sitedetails/MapleRoyals-The-Nostalgic-MapleStory-Server-79510?vote=1';
//Ranking Table
const RANK_TABLE_ROWS                   =           5;                                      //int
const RANK_TABLE_COL_START_DATE         =           true;                                   //boilean
const RANK_TABLE_COL_VOTE_ADDITIONAL    =           false;                                  //boolean
//Input Text
const MAX_CHARS_INPUT                    =          12;

class Message{
    public const SESSION_REQUERID = '<p class="v-info">You must be logged in to vote.</p>';
    public const SUCCESSFUL_VOTE = '<p class="v-success">Thank you for the Vote.</p>'; //line 94, vote.php
    public const DONTWINITEMS = '<p class="v-info">Sorry you did not win, try it on the next vote f7.</p>';
    public const CANTVOTE = '<p class="v-info">You can not vote until you complete '. TIMEFORTHENEXTVOTE .' hours.</p>';
    public const CANTVOTE_BYIP = '<p class="v-info">You can not vote here until you complete '. TIMEFORTHENEXTVOTE .' hours.</p>';
    public const VOTE_NOTICE = '<p class="v-alert">You will be directed to gtop100 in <span id="v-count_time">5</span> seconds...</p>';//line 107 and check line 97, vote.php
    public const INPUT_TEXT_NULL = '<p class="v-info">Please, write your username<p>';//line 61 security.php, check line 47 and 55 script.js
    public const SELECT_CHAR = '<p class="v-info">Please, select your character<p>';
    public const USER_DONT_EXIST = '<p class="v-alert">This is user is not exists<p>';
    public const PLAY_THE_GAME_FIRST = '<p class="v-info">Please login firts in the game...<p>';
    public const MIN_LV_REQUERID = '<p class="v-info">You need a character as a minimum level ' . MIN_LV_REQUERID . ' <p>';
    public const DONT_HAVE_CHAR = '<p class="v-info">You dont have a character in the game, please create one</p>';
    public const DEFAULT_CHAR_DONE = '<p class="v-info">Done...</p>';
    public const SECURITY_WARNING = '<p class="v-danger">We found a strange behavior</p>';
    //other line 252 connect.php,  line 42, 51, 67, 80, 137 vote.php
}

class Items{
    
    public const DIRECTORY = 'VotingSystem/img/';                       //line 87 vote.php

    private const PRIZE_1  = array(
        'status'        =>      true,
        'type'          =>      'continuous',                           //there are three types: continuos(c), requerid(r), accumulate(a)
        'quantity'      =>      [
            3,
            array('min' => 2, 'max' => 4),
            5
        ],
        'voteRequerid'  =>      [1, 50, 100, 250, 500, 1000],
        
        'item'          =>      array(
    
            'id'            =>      5220000,
            'name'          =>      'Gachapon Ticket',                  //iitem example
            'img'           =>      '5220000.png'

        )
    );

    private const PRIZE_2 = array(
        'status'        =>      true,
        'type'          =>      'requerid',
        'quantity'      =>      [1, 5],        
        'voteRequerid'  =>      [5, 44, 100, 198, 500, 1000],
        'item'          =>      array(
    
            'id'            =>      1142077,
            'name'          =>      'Absolute Victory Carnivalian Medal',//iitem example
            'img'           =>      '1142077.png'

        )
    );

    private const ADDITIONAL_PRIZE = array(
        'status'        =>      false,                                  //line 31
        'type'          =>      'accumulate',
        'quantity'      =>      2,
        'voteRequerid'  =>      [17, 50, 100, 250, 500, 1000],
        'item'          =>      array(
    
            'id'            =>      1122007,
            'name'          =>      "Spiegelmann's Necklace",           //iitem example
            'img'           =>      '1122007.png'

        )
    );
    //you can create new items
    public static function get(){
        return [self::PRIZE_1, self::PRIZE_2, self::ADDITIONAL_PRIZE];
    }
}