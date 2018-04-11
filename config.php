<?php

//Session, testing
session_start();

$_SESSION['id'] = '3';

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


class Items{

    private const PRIZE_1  = array(
        'status'        =>      true,
        'type'          =>      'continuous',
        'quantity'      =>      [
            array('min' => 0, 'max' => 1),
            array('min' => 1, 'max' => 1),
            array('min' => 1, 'max' => 3)
        ],
        'voteRequerid'  =>      [31, 100, 50, 100, 250, 500, 1000],
        
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
        'voteRequerid'  =>      [29, 50, 100, 198, 500, 1000],
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
        'voteRequerid'  =>      [27, 50, 100, 250, 500, 1000],
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