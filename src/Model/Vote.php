<?php

class Vote{

	private $db;

    function __construct(){
		$config = require dirname(__DIR__) . '/../Config/db.php';
        $this -> dB = new mysqli($config['host'], $config['username'], $config['password'], $config['database']);
		if ($this -> dB -> connect_errno) {
			echo "Error";
			exit();
		}else{
            echo "true";
		}
	}

	public function query($query){
		return $this -> db -> query($query);
	}
    
}