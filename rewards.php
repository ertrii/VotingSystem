<?php

class Reward {
    
    private $vote;

    function __construct($_vote){
        
        $this-> vote = intval($_vote);
        
    }

    private $rewards = array();

    private function countItem($prize, $i){
        $_count;

        if(is_array($prize['count'])){                        

            if($i < count($prize['count'])){
                
                if(is_array($prize['count'][$i])){
                    $_count = rand($prize['count'][$i]['min'], $prize['count'][$i]['max']);
                }else{
                    $_count = $prize['count'][$i];                    
                }
            }else{
                
                if(is_array(end($prize['count']))){
                    $_count = rand(end($prize['count'])['min'], end($prize['count'])['max']);
                }else{
                    $_count = end($prize['count']);
                }

                
            }
                        

        }else{
            $_count = $prize['count'];
        }
                    

        return array(
            'item'      =>      $prize['item'],
            'count'     =>      $_count
        );
    }

    private function process(){
        
        $_rewards = array();
        
        array_push($_rewards, Items::PRIZE_1, Items::PRIZE_2, Items::ADDITIONAL_PRIZE);
        
        foreach ($_rewards as $prize) {
            if(!$prize['status']) continue;
            
            $_countItemTemporal;

            for ($i=0; $i < count($prize['voteRequerid']); $i++) {

                switch ($prize['type']) {
                    case 'continuous':
                    case 'c':
                        if($this->vote >= $prize['voteRequerid'][$i])
                            $_countItemTemporal = $this->countItem($prize, $i);                             
                        break;

                    case 'requerid':
                    case 'r':
                        if($this->vote === $prize['voteRequerid'][$i]){
                            $this->rewards[] = $this->countItem($prize, $i);
                            break 2;
                        }
                        break;

                    default:
                        $this->rewards[] = array("item" => array('id' => -1, 'name' => 'error type', 'img' => 'error.png'), 'count' => null) ;
                        break 2;
                }                                                                                        

            }
            
            if($prize['type'] === 'continuous') $this->rewards[] = $_countItemTemporal;
            
        }
        
    }

    public function get(){        
        $this->process();
        return $this->rewards;
    }
}


$r = new Reward(500);

print_r($r->get());