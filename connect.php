<?php

//DataBase

include_once('config.php');

class DataBase{
    
    //=== Database Maple ===
    
    protected function connectRoyals($query){
        $dB = new mysqli(HOST, DB_USER, DB_PASS, DB_ROYALS);

		if ($dB->connect_errno) {
			echo "Error";
			exit();
		}else{
			//self->$msg = 'conexion establecida...';
			return $dB->query($query);
			
		}

    }
    protected function consultIdUser($user){
        $consult = $this -> connectRoyals("SELECT id FROM accounts WHERE name = '$user'");
        $id = $consult-> fetch_array();
        return ($consult) ? $id['id'] : false;
    }

    protected function getCharsUser($_id = null){
        $id = ($_id === null) ? $_SESSION['id'] : $_id;
        
        $get = $this -> connectRoyals("SELECT name, level FROM characters WHERE accountid = '$id'");
        $chars = $get-> fetch_all();
        
        if($get){
            return (count($chars) == 0) ? false : $chars;
        }else{
            return false;
        }
    }


    // === Database Vote ===
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

    protected $db_info = '';

    //=== Table Vote ===    
    protected function select($id, $row){
        $select = $this -> connect("SELECT $row FROM voted WHERE id_user = '$id' ");
        $_v = $select->fetch_array();
        return $_v[$row];
    }
    

    protected function insert($id, $char){
        $insert = $this -> connect("INSERT INTO voted(id_user, default_character) VALUES ('$id', '$char')");
        return ($insert) ? true : false;
    }

    protected function defaultChar($char){        
        $id = $_SESSION['id'];        
        $update = $this-> connect("UPDATE voted SET default_character = '$char', last_vote = last_vote WHERE id_user = '$id' " );
        return ($update) ? true : false;
    }

    protected function vote($user){        
        $id = $this -> consultIdUser($user);        //Verify if user exists in Royals's database (accounts table)
        if (!$id){
            $this -> db_info = 'This user does not exists';
            return false;
        }

        $chars = $this -> getCharsUser($id);
        //Verificar si existe el usuario en la table vote sino agregarlo consiguiendo los datos de la tabla de maple        
        $userExistsInVote = $this -> connect("SELECT IF (EXISTS (SELECT id_user FROM voted WHERE id_user = $id), 1, 0)");

        if (!$userExistsInVote -> fetch_array()[0]){
            
            if(!$chars){
                $this-> db_info = 'You dont have a character';
                return false;
            }else{
                
                $this->insert($id, $chars[0][0]);   //First Character for Default
            }
            

        }
        $lowLv = false;

        foreach ($chars as $char) {
            if(MIN_LV_REQUERID <= intval($char[1])){                
                $lowLv = true;
                break;
            }
        }

        if(!$lowLv){
            $this -> db_info = 'you need a character as a minimum level 15';
            return false;
        }

        $update = $this -> connect("UPDATE voted SET votes = votes + 1  WHERE id_user = $id");
                
        return ($update) ? $this -> select($id, 'votes') : false;
    }
    
    
}
