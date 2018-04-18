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
        $id = ($_id === null) ? $_SESSION[SESSION_VARIABLE] : $_id;
        
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
            $this->db_info = Message::USER_DONT_EXIST;
            return false;
        } else{            
            $address['last_vote'] = $this->select($address['id'], 'last_vote');
            $address['ip_control'] = $this->select($address['id'], 'ip_control');

            if ($address['last_vote'] === null){
                $address['last_vote'] = '2013-05-19 00:00:00';
            }
            
            foreach ($address as $add) {                
                if($add === null) {
                    $this->db_info = Message::PLAY_THE_GAME_FIRST;
                    return false;
                }
            }
        }
        return $address;
    }

    //=======================================//
    //          === Database Vote ===
    private $conDB;

    public function connect($query){
        $dB = new mysqli(HOST, DB_USER, DB_PASS, DB_VOTE);

		if ($dB->connect_errno) {
			echo "Error";
			exit();
		}else{
            $this->conDB = $dB;
			return $dB->query($query);			
		}
    }    
    public function close_DB(){
        $this->conDB->close();
    }
    public function escape_string($string){
        $str = mysqli_real_escape_string(new mysqli(HOST, DB_USER, DB_PASS, DB_VOTE), $string);
        return $str;
    }
    //=== Table Vote ===    
    protected function select($id, $row){
        $select = $this -> connect("SELECT $row FROM voted WHERE id_user = '$id' ");
        $_v = $select->fetch_array();
        return $_v[$row];
    }

    protected function defaultChar($char){        
        $id = $_SESSION[SESSION_VARIABLE];
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

    protected function registerUserInVoteDB($id, $char){
        $this -> connect("INSERT INTO voted(id_user, default_id_character, last_vote) VALUES ($id, '$char', '2013-05-19 00:00:00')");
    }


    protected function vote($user, $ip = false){        
        $id = $this -> consultIdUser($user);        //Verify if user exists in Maple's database (accounts table)
        if (!$id){
            $this -> db_info = Message::USER_DONT_EXIST;
            return false;
        }

        $chars = $this -> getCharsUser($id);
        //Verificar si existe el usuario en la table voted de Vote Database sino agregarlo consiguiendo los datos de la tabla de maple        
        $userExistsInVoteDB = $this -> connect("SELECT IF (EXISTS (SELECT id_user FROM voted WHERE id_user = $id), 1, 0)");

        if (!$userExistsInVoteDB -> fetch_array()[0]){
            
            if(!$chars){
                $this-> db_info = Message::DONT_HAVE_CHAR;
                return false;
            }else{
                $this -> registerUserInVoteDB($id, $chars[0][0]);
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
            $this -> db_info = Message::MIN_LV_REQUERID;
            return false;
        }

        if($ip && IPCONTROL){            
            $this -> connect("UPDATE ipcontrol SET votes = votes + 1 WHERE ip = '$ip'");
        } 
        
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
    protected function setGameItems($idUser, $items){
        $idChar = $this->select($idUser, 'default_id_character');        
        if($idChar == -1){
            return false;
        }
        $countItem = 0;        
        foreach ($items as $item) {
            $countItem++;
            $idItem = $item['item']['id'];
            $countItem = $item['quantity'];
            $this-> connectMaple("INSERT INTO inventoryitems(characterid, accountid, itemid, quantity) VALUES($idChar, $idUser, $idItem, $countItem)");
        }
        return ($countItem > 0) ? true : false;
    }

    /*
    ==================================================
                === Vote Ranking ===
    ==================================================
    */
    public function ranking(){
        $rank = $this -> connect("SELECT id_user, start_date, votes, vote_additional, @cRank := @cRank + 1 AS rank FROM voted v, (SELECT @cRank := 0) r ORDER BY votes DESC, start_date ASC LIMIT " . RANK_TABLE_ROWS);
        $_rank = $rank -> fetch_all();

        for ($i=0; $i < count($_rank); $i++) { 
            $_id = $_rank[$i][0];
            $user = $this -> connectMaple("SELECT name FROM accounts WHERE id = $_id");
            $_rank[$i][] = $user -> fetch_array()['name'];//adding
        }
        $user_position = 0;
        
        if(RANK_TABLE_COL_START_DATE && RANK_TABLE_COL_VOTE_ADDITIONAL){
            $ranking_template = '<table class="v-ranking_table"><tr><th>Top</th><th>Name</th><th>Votes</th><th>Vote Additional</th><th>Start Date</th></tr>';
        }elseif(RANK_TABLE_COL_START_DATE){
            $ranking_template = '<table class="v-ranking_table"><tr><th>Top</th><th>Name</th><th>Votes</th><th>Start Date</th></tr>';
        }elseif(RANK_TABLE_COL_VOTE_ADDITIONAL){
            $ranking_template = '<table class="v-ranking_table"><tr><th>Top</th><th>Name</th><th>Votes</th><th>Vote Additional</th></tr>';
        }else{
            $ranking_template = '<table class="v-ranking_table"><tr><th>Top</th><th>Name</th><th>Votes</th></tr>';
        }

        foreach ($_rank as $_r) {
            if(RANK_TABLE_COL_START_DATE && RANK_TABLE_COL_VOTE_ADDITIONAL){                
                $ranking_template .= "<tr><td>$_r[4]</td> <td>$_r[5]</td> <td>$_r[2] </td> <td>$_r[3]</td> <td>$_r[1]</td></tr>";
            }elseif(RANK_TABLE_COL_START_DATE){                
                $ranking_template .= "<tr><td>$_r[4]</td> <td>$_r[5]</td> <td>$_r[2]</td> <td>$_r[1]</td></tr>";
            }elseif(RANK_TABLE_COL_VOTE_ADDITIONAL){                
                $ranking_template .= "<tr><td>$_r[4]</td> <td>$_r[5]</td> <td>$_r[2]</td> <td>$_r[3]</td></tr>";
            }else{                
                $ranking_template .= "<tr><td>$_r[4]</td> <td>$_r[5]</td> <td>$_r[2]</td></tr>";
            }
                        
        }

        $ranking_template .= '</table>';

        if(isset($_SESSION[SESSION_VARIABLE])) {
            $id_user = $_SESSION[SESSION_VARIABLE];
            $rankUser = $this -> connect("SELECT 1 + (SELECT COUNT(*) FROM voted a WHERE a.votes > b.votes) AS rank FROM voted b WHERE id_user = $id_user ORDER BY rank, start_date LIMIT 1");
            $_rankUser = $rankUser -> fetch_array();

            $user_position = ($_rankUser[0] == null) ? 0 : $_rankUser[0] ;
        }
        return ['table' => $ranking_template, 'user' => (isset($_SESSION[SESSION_VARIABLE])) ? '<span class="v-user_ranking"> Your Position: ' . $user_position . '</span>': '' ];
    }
}
