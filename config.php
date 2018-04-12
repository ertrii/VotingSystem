<?php

//Session, testing
session_start();

$_SESSION['id'] = '4';

//Config DataBase

const VOTING_SYSTEM             =           true;    // on / off
//HOST
const HOST                      =           'localhost';

//USER DATABASE
const DB_USER                   =           'root';
const DB_PASS                   =           '';

//DATABASE VOTE
const DB_VOTE                   =           'vote';
//DATABASE MAPLE
const DB_MAPLE                  =           'maple_maplelife';  //Example

//System
const TIMEZONE                  =           'America/Lima';
const TIMEFORTHENEXTVOTE        =           2;  //hours
const IPCONTROL                 =           true;
const MIN_LV_REQUERID           =           15;
//const VERIFY

const ADDITIONAL_VOTE           =           true;

//System Vote
const VOTE_LINK                 =           'http://www.gtop100.com/topsites/MapleStory/sitedetails/MapleRoyals-The-Nostalgic-MapleStory-Server-79510?vote=1';

const VOTE_INFO                 =           (VOTING_SYSTEM) ? 'try the new voting system' : 'voting system in maintenance...';

class Message{
    
    public const SUCCESSFUL_VOTE = '<p class="v-thanks_for_vote">Thank you for the Vote.</p>'; //line 119 vote.php    
    public const DONTWINITEMS = '<p class="v-not_win_items">Sorry you did not win, try it on the next vote.</p>';
    public const CANTVOTE = '<p class="v-complete_hours">You can not vote until you complete '. TIMEFORTHENEXTVOTE .' hours.</p>';
    public const CANTVOTE_BYIP = '<p class="v-complete_hours">You can not vote here until you complete '. TIMEFORTHENEXTVOTE .' hours.</p>';
    public const VOTE_NOTICE = '<p class="v-vote_notice">You will be directed to gtop100 in <span id="v-count_time">5</span> seconds...</p>';
    public const INPUT_TEXT_NULL = '<p class="v-vote_notice">Please, write your user name<p>';
    public const SELECT_CHAR = '<p class="v-vote_notice">Please, select your character<p>';    
    public const USER_DONT_EXIST = '<p class="v-vote_notice">This is user is not exists<p>';
    public const PLAY_THE_GAME_FIRST = '<p class="v-vote_notice">Please login firts in the game...<p>';
    public const MIN_LV_REQUERID = '<p class="v-vote_notice">you need a character as a minimum level 15<p>';
    public const DONT_HAVE_CHAR = '<p class="v-config_notice">You dont have a character in the game, please create one</p>';
    public const DEFAULT_CHAR_DONE = '<p class="v-config_done">Done...</p>';
}

class Items{

    private const PRIZE_1  = array(
        'status'        =>      false,
        'type'          =>      'continuous',
        'quantity'      =>      [
            array('min' => 0, 'max' => 1),
            array('min' => 1, 'max' => 1),
            array('min' => 1, 'max' => 3)
        ],
        'voteRequerid'  =>      [1, 100, 50, 100, 250, 500, 1000],
        
        'item'          =>      array(
    
            'id'            =>      84565465,
            'name'          =>      'gachapom',
            'img'           =>      'gacha.png'
    
        )
            
    );

    private const PRIZE_2 = array(
        'status'        =>      false,
        'quantity'      =>      1,
        'type'          =>      'c',
        'voteRequerid'  =>      [9, 50, 100, 198, 500, 1000],
        'item'          =>      array(
    
            'id'            =>      123456789,
            'name'          =>      'medall',
            'img'           =>      'medall.jpg'
    
        )
    
    );

    private const ADDITIONAL_PRIZE = array(
        'status'        =>      false,
        'quantity'      =>      2,
        'type'          =>      'c',
        'voteRequerid'  =>      [17, 50, 100, 250, 500, 1000],
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