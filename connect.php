<?php

//DataBase

include_once('config.php');

class DataBase{

    protected function connect($query){
        $dB = new mysqli(HOST, DB_USER, DB_PASS, DB_VOTE);

		if ($dB->connect_errno) {
			echo "Error";
			exit();
		}else{
			//self->$msg = 'conexion establecida...';
			return $dB->query($query);
			
		}
    }

    //=== Table Vote ===    
    protected function select($user, $row){
        $select = $this -> connect("SELECT $row FROM voted WHERE user = '$user' ");
        $_v = $select->fetch_array();
        return $_v['votes'];
    }
    

    protected function insert($user, $char){
        $insert = $this -> connect("INSERT INTO voted(user, default_character) VALUES ('$user', '$char')");
        return ($insert) ? true : false;
    }

    protected function defaultChar($char){        
        $user = $_SESSION['user'];        
        $update = $this-> connect("UPDATE voted SET default_character = '$char', last_vote = last_vote WHERE user = '$user' " );
        return ($update) ? true : false;
    }

    protected function vote($user){
        $update = $this -> connect("UPDATE voted SET votes = votes + 1  WHERE user = '$user'");
        return ($update) ? $this -> select($user, 'votes') : false;
    }
    
    //=== Table Maple ===
    /*
    protected function consult(){
        $consult = $this -> connect("SELECT user FROM voted WHERE user = '$user'");
    }
    */
}
