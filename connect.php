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
    protected function select($user){
        $select = $this -> connect("SELECT votes FROM voted WHERE user = '$user' ");
        $_v = $select->fetch_array();
        return $_v['votes'];
    }
    

    protected function insert($user, $char){
        $insert = $this -> connect("INSERT INTO voted(user, default_character) VALUES ('$user', '$char')");
        return ($insert) ? true : false;
    }

    protected function update($user){
        $update = $this -> connect("UPDATE vote SET votes = votes + 1  WHERE id = '$user'");
        return ($update) ? true : false;
    }
    //=== Table Maple ===
    /*
    protected function consult(){
        $consult = $this -> connect("SELECT user FROM voted WHERE user = '$user'");
    }
    */
}
