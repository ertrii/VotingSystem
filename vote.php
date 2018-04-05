<?php

//Voting System
include_once('connect.php');
include_once('rewards.php');
class Vote extends DataBase
{
    private $chars = array();
    function __construct(){        
        
        if (isset($_SESSION['id'])){
            $_chars =  parent::getCharsUser();
            if (!$_chars){
                $this -> chars = null;
                return;
            }
            foreach ($_chars as $char) {
                array_push($this -> chars, $char[0]);
            }
        }
        
    }
    
    private $vote = 0;
    private $status = true;    
    
    //info about vote
    public $info = array('text' => '', 'template' => '', 'reward' => null, 'status' => 0);

    //Reward after the vote
    private function reward(){        

        $r = new Reward($this->vote, 51);
        $_reward = $r->get();
        $this -> info['reward'] = $_reward;

        $p = 'Thank you for the Vote. You Total Votes: ' . $this->vote;

        if(count($_reward) === 0){
            $p .= '<br>Sorry you did not win, try it on the next vote:';
        }else{
            $p .= '<br>You got:';
        }
        foreach ($_reward as $prize) {
            $p .= '<br>* ' . $prize['count'] . " " .$prize['item']['name'];
        }

        return $p;

    }

    /** Template HTML <form>  */
    private $form_Vote ='
        <form method="post">
            <input type="text" name="user" id="" placeholder="User">
            <input type="submit" value="Vote" name="vote">
        </form>
        ';

    private function formConfig(){
        
        if ($this -> chars === null)
            return '<p id="error">Please create your first character firts</p>';
            //return null;
        

        $_chars = '';
        foreach ($this -> chars as $c) {
            $_chars .= '<option value=" ' . $c . '">' . $c . '</option>';
        }

        $form_Config = '
        <form method="post">            
            <select name="char">'. $_chars .'</select>
            <input type="submit" value="Done">
        </form>
        ';

        return $form_Config;
    }
       

    private function prepareInfo($text, $status = 0){
        $this -> info['text'] = $text;        
        
        if($status !== 1){
            $this -> info['template'] = '<p id="error">' . $text . '</p>';            
        } 
        $this -> info['template'] = '<p id="success"> '. $text . '</p>';
        
        $this -> info['status'] = $status;          // 0 = False / 1 = true        
    }
    
    //Start Vote
    private function start($user){
                
        if ($user == ''){            
            $this->prepareInfo('Please, write your user name');
            return;
        }        

        
        $this->vote = parent::vote($user);          //Database Consult and save

        if (!$this -> vote) {            
            $this->prepareInfo($this->db_info, 0);
        }else{
            //prepare info and get text reward
            $this->prepareInfo($this -> reward(), 1);
        }        
        
    }

    //Config default Character
    private function configDefaultChar($char){
        if ($char == '') {
            $this->prepareInfo('Please, select you character');
            return;
        }        
        
        parent::defaultChar($char);

        $this->prepareInfo('done', 1);        
    }



    //Get form templates
    public function getForm_Vote(){                
        if (VOTING_SYSTEM) {
            if(isset($_POST['vote'])) $this -> start($_POST['user']);
            return $this->form_Vote;
        }else{
            return VOTE_INFO;
        }        
    }

    public function getForm_Config(){
        if (!VOTING_SYSTEM) return null;
        
        //if there is a session, return form_Config
        if (isset($_SESSION['id'])) {
            if(isset($_POST['char'])) $this -> configDefaultChar($_POST['char']);
            return $this->formConfig();
        } else{
            return null;
        }        
    }
}
