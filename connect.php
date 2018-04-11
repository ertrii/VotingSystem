<?php

//DataBase

include_once('config.php');

class DataBase{
    
    //=== Database Maple ===
    protected $db_info = '';

    protected function connectMaple($query){
        $dB = new mysqli(HOST, DB_USER, DB_PASS, DB_MAPLE);

		if ($dB->connect_errno) {
			echo "Error";
			exit();
		}else{
			//self->$msg = 'conexion establecida...';
			return $dB->query($query);
			
		}

    }
    protected function consultIdUser($user){
        $consult = $this -> connectMaple("SELECT id FROM accounts WHERE name = '$user'");
        $id = $consult-> fetch_array();
        return ($consult) ? $id['id'] : false;
    }

    protected function getCharsUser($_id = null){
        $id = ($_id === null) ? $_SESSION['id'] : $_id;
        
        $get = $this -> connectMaple("SELECT id, name, level FROM characters WHERE accountid = '$id'");
        $chars = $get-> fetch_all();
        
        if($get){
            return (count($chars) == 0) ? false : $chars;
        }else{
            return false;
        }
    }

    protected function getNameChar($id){
        $name = $this->connectMaple("SELECT name FROM characters WHERE id = $id");
        return $name -> fetch_array()['name'];
    }

    protected function getAddress($user){
        $consult = $this -> connectMaple("SELECT id, ip FROM accounts WHERE name = '$user'");
        $address = $consult-> fetch_array();
        if ($address === null) {
            $this->db_info = 'This is user is not exists' ;
            return false;
        } else{            
            $address['last_vote'] = $this->select($address['id'], 'last_vote');

            if ($address['last_vote'] === null){
                $address['last_vote'] = '2013-05-19 00:00:00';
            }
            
            foreach ($address as $ipmac) {                
                if($ipmac === null) {
                    $this->db_info = 'Please login firts in the game...';
                    return false;
                }
            }
        }
        return $address;
    }

    //=======================================//
    //          === Database Vote ===
    protected function connect($query){
        $dB = new mysqli(HOST, DB_USER, DB_PASS, DB_VOTE);

		if ($dB->connect_errno) {
			echo "Error";
			exit();
		}else{			
			return $dB->query($query);			
		}
    }    

    //=== Table Vote ===    
    protected function select($id, $row){
        $select = $this -> connect("SELECT $row FROM voted WHERE id_user = '$id' ");
        $_v = $select->fetch_array();
        return $_v[$row];
    }
    

/*    protected function insert($id, $char){
        $insert = $this -> connect("INSERT INTO voted(id_user, default_id_character) VALUES ('$id', '$char')");
        return ($insert) ? true : false;
    }
*/
    protected function defaultChar($char){        
        $id = $_SESSION['id'];
        $_chars = $this->getCharsUser($id);

        //if there is an insertion of -1, it is because there was a manipulation in the configuration form
        $id_char = -1;
        
        foreach ($_chars as $_char) {                        
            
            if($_char[1] == $char){
                $id_char = $_char[0]; //getting id satisfactorily
                break;
            }
        }
        $update = $this-> connect("UPDATE voted SET default_id_character = '$id_char', last_vote = last_vote WHERE id_user = '$id' " );
        return ($update) ? true : false;
    }

    protected function vote($user, $ip = false){        
        $id = $this -> consultIdUser($user);        //Verify if user exists in Maple's database (accounts table)
        if (!$id){
            $this -> db_info = 'This user does not exists';
            return false;
        }

        $chars = $this -> getCharsUser($id);
        //Verificar si existe el usuario en la table voted de Vote Database sino agregarlo consiguiendo los datos de la tabla de maple        
        $userExistsInVoteDB = $this -> connect("SELECT IF (EXISTS (SELECT id_user FROM voted WHERE id_user = $id), 1, 0)");

        if (!$userExistsInVoteDB -> fetch_array()[0]){
            
            if(!$chars){
                $this-> db_info = 'You dont have a character';
                return false;
            }else{                
                //$this->insert($id, $chars[1][0]);
                print_r($chars);
                $char = $chars[0][0];               //First Character for Default
                $this -> connect("INSERT INTO voted(id_user, default_id_character) VALUES ($id, '$char')");
            }
            
        }

        $lowLv = false;

        foreach ($chars as $char) {
            if(MIN_LV_REQUERID <= intval($char[2])){                
                $lowLv = true;
                break;
            }
        }

        if(!$lowLv){
            $this -> db_info = 'you need a character as a minimum level 15';
            return false;
        }

        if($ip && IPCONTROL) $this -> connect("UPDATE ipcontrol SET votes = votes + 1 WHERE ip = '$ip'");
        
        if(ADDITIONAL_VOTE){
            $update = $this -> connect("UPDATE voted SET votes = votes + 1, vote_additional = vote_additional + 1 WHERE id_user = $id");
        }else{
            $update = $this -> connect("UPDATE voted SET votes = votes + 1 WHERE id_user = $id");
        }
        
        return ($update) ? $this -> select($id, 'votes') : false;
    }


    protected function ipReport($ip){
        $ipRegistered = $this -> connect("SELECT IF (EXISTS (SELECT id FROM ipcontrol WHERE ip = '$ip'), 1, 0)");

        if(!$ipRegistered->fetch_array()[0]) $this -> connect("INSERT INTO ipcontrol(ip) VALUES ('$ip')");

        $consult = $this->connect("SELECT last_vote, registration_date, banned FROM ipcontrol WHERE ip = '$ip'");

        return $consult->fetch_array();
    }

    protected function banIP($ip, $status = true){
        $_status = ($status) ? 1 : 0;
        return ($this-> connect("UPDATE ipcontrol SET banned = $_status WHERE ip = $ip")) ? true : false;
    }
    /*
    ====================================================
        === Insert Items by vote in MapleStory Game ===
    ====================================================
     */
    protected function setGameItems($items, $idUser){
        $idChar = $this->select($idUser, 'default_id_character');
        foreach ($items as $item) {
            $idItem = $item['item']['id'];
            $countItem = $item['quantity'];
            $this-> connectMaple("INSERT INTO inventoryitems(characterid, accountid, itemid, quantity) VALUES($idChar, $idUser, $idItem, $countItem)");
        }
    }
        
}
