<?php

$db = require dirname(__DIR__) . '/Model/Vote.php';
$reward = require dirname(__DIR__) . '/../Config/reward.php';

class VoteController extends Vote{

    function __construct()
    {
        parent::__construct();
    }

}