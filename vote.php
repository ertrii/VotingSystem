<?php

//Voting System
include_once('connect.php');

class Vote extends DataBase
{
    private $vote = 0;
    private $status = true;
    private $prize1 = array('status' => true, 'id' => 1565189, 'img' => 'gacha.jpg', 'count' => 1);
    private $prize2 = array('status' => false, 'id' => 1234567, 'img' => 'medall.jpg', 'count' => 1);
    private $additionalPrize = array('status' => false, 'id' => 01561, 'img' => 'additionalPrize.png', 'count' => 1);

    //Voting System
    private function process(){
        $_v = $this->vote;
        if($_v >= 1000){
            $this->prize1['count'] = rand(5, 10);
        }elseif($_v >= 500){
            $this->prize1['count'] = rand(3, 7);
        }elseif($_v >= 250){
            $this->prize1['count'] = rand(2, 5);
        }elseif($_v >= 100){
            $this->prize1['count'] = rand(1, 3);
        }elseif($_v >= 50){
            $this->prize1['count'] = rand(1, 2);
        }elseif($_v >= 10){
            $this->prize1['count'] = rand(1, 1);
        }else{
            $this->prize1['count'] = rand(0, 1);
        }
    }
    //info about vote
    public $info = array('text' => '', 'template' => '', 'reward' => null, 'status' => 0);

    //private $_reward = array();

    //Reward after the vote
    private function reward(){

        $this->process();

        $_reward = array(
            'prize1' => ($this->prize1['status'] ? $this->prize1 : false),
            'prize2' => ($this->prize2['status'] ? $this->prize2 : false),
            'additionalPrize' => ($this->additionalPrize['status'] ? $this->additionalPrize : false),
            'allVotes' => $this->vote,
            'nextVote' => 'time',
            'status' => $this->status
        );

        //$this->_reward = $_reward;
        $this -> info['template'] .= '<p> Your character got ' . $this -> prize1['count'] .' gachapom, <strong>Vote : '. $this-> vote . '</strong></p>';
        $this -> info['reward'] = $_reward;

    }

    /** Template HTML <form>  */
    private $form_Vote ='
        <form method="post">
            <input type="text" name="user" id="" placeholder="User">
            <input type="submit" value="Vote" name="vote">
        </form>
        ';

    private $form_Config = '
        <form method="post>            
            <select name="char">
                <option value="Char1">Char 1</option>
                <option value="Char2">Char 2</option>
                <option value="Char3">Char 3</option>
            </select>            
            <input type="submit" value="Done">
        </form>
        ';

    
    //Get form templates
    public function getForm_Vote(){

        return (VOTING_SYSTEM) ? $this->form_Vote : VOTE_INFO;
        
    }

    public function getForm_Config(){

        if (!VOTING_SYSTEM) return null;

        //if there is a session, return form_Config
        return (isset($_SESSION['user'])) ? $this->form_Config : null;                   
        
    }    
    

    private function prepareInfo($text, $status = 0){
        $this -> info['text'] = $text;
        
        if($status === 1){
            $this -> info['template'] = '<p id="error">' . $text . '</p>';                    
        } 
        $this -> info['template'] = '<p id="success"> '. $text . '</p>';
        
        $this -> info['status'] = $status;    //0 = False / 1 = true
    }
    
    //Start Vote
    public function start($user){
                
        if ($user == ''){            
            $this->prepareInfo('Please, write your user name');
            return;
        }
        $this->vote++;
        //test
        $this->vote = parent::vote($user);
        $this->prepareInfo('Voted...', 1);
        $this -> reward();
    }

    //Config default Character
    public function defaultChar($char){
        if ($char == '') {
            $this->prepareInfo('Please, select you character');
            return;
        }
        //test
        $this->prepareInfo('done', 1);
    }
}
