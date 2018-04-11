<?php

//Session, testing
session_start();

$_SESSION['id'] = '1';

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
const TIMEFORTHENEXTVOTE        =           0.02;  //hours
const IPCONTROL                 =           true;
const MIN_LV_REQUERID           =           15;
//const VERIFY

const ADDITIONAL_VOTE           =           true;

//System Vote
const VOTE_LINK                 =           'http://www.gtop100.com/topsites/MapleStory/sitedetails/MapleRoyals-The-Nostalgic-MapleStory-Server-79510?vote=1';

const VOTE_INFO                 =           (VOTING_SYSTEM) ? 'try the new voting system' : 'voting system in maintenance...';

class Message{
    public const CANTVOTE = 'You can not vote until you complete 24 hours. ';
    public const CANTVOTE_BYIP = 'You can not vote here until you complete 24 hours. ';
    public const SUCCESSFUL_VOTE = 'Thank you for the Vote. ';
    public const DONTWINITEMS = 'Sorry you did not win, try it on the next vote.';
    public const DONT_HAVE_CHAR = 'You dont have a character, please create your character first';
    public const INPUT_TEXT_NULL = 'Please, write your user name';
    public const SELECT_CHAR = 'Please, select your character';
    public const DEFAULT_CHAR_DONE = 'Done';
    public const USER_DONT_EXIST = 'This is user is not exists';
    public const PLAY_THE_GAME_FIRST = 'Please login firts in the game...';
    public const MIN_LV_REQUERID = 'you need a character as a minimum level 15';
}

class Items{

    private const PRIZE_1  = array(
        'status'        =>      true,
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
        'status'        =>      true,
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
        'status'        =>      true,
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