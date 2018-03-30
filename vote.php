<?php

//System Vote
include_once('connect.php');

class Vote extends DataBase
{

    private $form_Vote ='
        <form action="post">
            <input type="text" name="user" id="" placeholder="User">
            <input type="submit" value="Vote">
        </form>
        ';

    private $form_Config = '
        <form action="post">
            
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

        return (isset($_SESSION['user'])) ? $this->form_Config : null;                   
        
    }
    
}
