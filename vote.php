<?php

//System Vote
include_once('connect.php');

class Vote extends DataBase
{

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

    public function getForm_Vote(){

        return (VOTING_SYSTEM) ? $this->form_Vote : VOTE_INFO;
        
    }

    public function getForm_Config(){

        if (!VOTING_SYSTEM) return null;

        //if there is a session, return form_Config
        return (isset($_SESSION['user'])) ? $this->form_Config : null;                   
        
    }
    

    public $info = '';
    
    public function start($user){

        if ($user == ''){
            $this -> info = '<p id="error"> Please, write your user name </p>';
            return;
        }
        //test
        $this -> info = '<p id="success"> vote </p>';
    }

    public function defaultChar($char){
        if ($char == '') {
            $this -> info = '<p id="error"> Please, select you character </p>';
            return;
        }
        //test
        $this -> info = '<p id="success"> done </p>';
    }
}
