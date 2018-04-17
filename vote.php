<?php

//Voting System
include_once('connect.php');
include_once("security.php");
include_once('rewards.php');
class Vote extends DataBase
{
    private $chars = null;
    //info about vote
    public $info = array(
        'formVote' => array('text' => '', 'status' => 0),
        'formConfig' => array('text' => '', 'status' => 0),
        'reward' => null);

    function __construct(){        
        
        if (isset($_SESSION[SESSION_VARIABLE])){
            $_chars =  parent::getCharsUser();
            if (!$_chars){
                $this -> chars = null;
                return;
            }
            foreach ($_chars as $char) {                
                $this -> chars[] = $char;
            }
        }
        
    }

    private function canIvote($user){
        $address = parent::getAddress($user);        
        if(!$address){
            $this->prepareInfo($this->db_info);
            return false;
        }
        date_default_timezone_set(TIMEZONE);

        $_current_date  = new DateTime(date("Y-m-d H:i:s"));

        $_ip = Security::IP();  //security.php

        if(IPCONTROL && $address['ip_control'] == 1){   //ip_control if is true            
            $ipInfo = parent::ipReport($_ip);

            if($ipInfo['banned'] == 1){
                $this -> prepareInfo("IP $_ip is banned...");
                return false;
            }

            $_nextDateForVoteByIP = new DateTime(date('Y-m-d H:i:s', strtotime($ipInfo['last_vote'] . '+'. TIMEFORTHENEXTVOTE .'hour')));

            if($_current_date <= $_nextDateForVoteByIP) {                
                $_intervalByIP = $_current_date->diff($_nextDateForVoteByIP);
                $_remaining_time = (TIMEFORTHENEXTVOTE > 24) ? $_intervalByIP->format("%Y-%M-%D %H:%I:%S") : $_intervalByIP->format("%H:%I:%S");
                $this->prepareInfo(Message::CANTVOTE_BYIP . '<p class="v-remaining_time">Remaining time: ' . $_remaining_time . '</p>');
                return false;
            }

        }

        $_nextDateForVote = new DateTime(date('Y-m-d H:i:s', strtotime($address['last_vote'] . '+'. TIMEFORTHENEXTVOTE .'hour')));

        $_interval = $_current_date->diff($_nextDateForVote);
        $_remaining_time = (TIMEFORTHENEXTVOTE > 24) ? $_interval->format("%Y-%M-%D %H:%I:%S") : $_interval->format("%H:%I:%S");

        if($_current_date >= $_nextDateForVote){
            
            return ['ip' => $_ip, 'ip_control' => ($address['ip_control'] == 1) ? true : false];     //true
            
        }else{
            $this->prepareInfo(Message::CANTVOTE . '<p class="v-remaining_time">Remaining time: ' . $_remaining_time . '</p>');
            return false;
        }
    }
    
    private $vote = 0;        

    //Reward after the vote
    private function reward($user){        
        $_idUser = parent::consultIdUser($user);
        $r = new Reward($this->vote, $_idUser);
        $_reward = $r->get();
        $this -> info['reward'] = $_reward;

        $div = Message::SUCCESSFUL_VOTE . '<p class="v-total_votes">Total Votes: ' . $this->vote . '</p>';
        //Link: hidden, Delete if you do not want to be redirected automatically.
        $div .= '<a id="v-link_vote" href=" ' . VOTE_LINK .'" style="display: none">xD</a>';
        
        if(count($_reward) === 0){
            $_reward = null;
            print_r($_reward);
            $div .= Message::DONTWINITEMS;
        }
        else{
            parent::setGameItems($_reward, $_idUser);            
            $div .= '<p class="v-sub_title_items">You got:</p>
            <ul class="v-list_items">';
            foreach ($_reward as $prize) {
                $div .= '<li> ' . $prize['quantity'] . " " . $prize['item']['name'] . '</li>';
            }
            $div .= '</ul>';
        }
        return $div .= Message::VOTE_NOTICE;
    }

    /** Template HTML <form>  */
    private function form_Vote(){
        return '<form method="post" id="formVote" action="'. htmlspecialchars($_SERVER['PHP_SELF']) . '">
                    <input type="text" name="user" id="" placeholder="User">
                    <input type="submit" value="VOTE" name="vote">
                </form>';
    }

    private function formConfig(){
        
        if ($this -> chars === null)
            return Message::DONT_HAVE_CHAR;
        $_chars = '';
        foreach ($this -> chars as $c) {
            $_chars .= '<option value="' . $c[1] . '">' . $c[1] . '</option>';
        }

        $_defaultChar = parent::select($_SESSION[SESSION_VARIABLE], 'default_id_character');
        if($_defaultChar === null) {
            parent::registerUserInVoteDB($_SESSION[SESSION_VARIABLE], $this -> chars[0][0]);            
            $_defaultChar = parent::select($_SESSION[SESSION_VARIABLE], 'default_id_character');
        }
        $nameChar = parent::getNameChar($_defaultChar);

        if($nameChar == '') $nameChar = 'error e1000';  //means that the name was not obtained.

        $form_Config = '
        <p class="v-default_char">Default Character: '. $nameChar .'</p>
        <form method="post" id="formConfig" action="'. htmlspecialchars($_SERVER['PHP_SELF']) .'">
            <select name="char">'. $_chars .'</select>
            <input type="submit" value="DONE">
        </form>
        ';

        return $form_Config;
    }

    private function prepareInfo($text, $status = 0){
        $post = '';
        if(isset($_POST['vote'])){
            $post = 'formVote';
        }
        if(isset($_POST['char'])){
            $post = 'formConfig';
        }
        $this -> info[$post]['text'] = $text;
        
        $this -> info[$post]['status'] = $status;          // 0 = False / 1 = true        
    }
    
    //Start Vote
    private function start($user){

        $_user = Security::filter($user);
        if($_user === false) {
            $this->prepareInfo(Security::$info);
            return;
        }
        
        $cIv = $this->canIvote($_user);
        if(!$cIv){
            return;
        }else{
            if(IPCONTROL && $cIv['ip_control']){

                $this->vote = parent::vote($_user, $cIv['ip']);          //Database Consult and save
            }else{
                $this->vote = parent::vote($_user);          //Database Consult and save
            }
        }
        
        if (!$this -> vote) {            
            //false
            $this->prepareInfo($this->db_info, 0);
        }else{
            //succsess            
            $this->prepareInfo($this -> reward($_user), 1);
        }        
        
    }

    //Config default Character
    private function configDefaultChar($char){
        $char = Security::filter($char);
        if ($char === false) {
            $this->prepareInfo(Security::$info);
            return;
        }
        
        parent::defaultChar($char);
        $this->prepareInfo(Message::DEFAULT_CHAR_DONE , 1);
    }

    //Get form templates
    public function getForm_Vote(){                
        if (VOTING_SYSTEM) {
            if(isset($_POST['vote'])) $this -> start($_POST['user']);
            return $this->form_Vote();
        }else{
            return VOTE_INFO;
        }        
    }

    public function getForm_Config(){
        if (!VOTING_SYSTEM) return null;
        
        //if there is a session, return form_Config
        if (isset($_SESSION[SESSION_VARIABLE])) {
            if(isset($_POST['char'])) $this -> configDefaultChar($_POST['char']);
            return $this->formConfig();
        } else{
            return null;
        }        
    }
}
