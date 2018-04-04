<?php

class Reward {
    
    private $vote;

    function __construct($_vote){
                
        $this-> vote = intval($_vote);
        
    }

    private $rewards = array();

    private function process(){
        
        $_rewards = array();
        
        array_push($_rewards, Items::PRIZE_1, Items::PRIZE_2, Items::ADDITIONAL_PRIZE);
        
        foreach ($_rewards as $prize) {
            if(!$prize['status']) continue;
            

            for ($i=0; $i < count($prize['voteRequerid']); $i++) { 
                
                if($this->vote === $prize['voteRequerid'][$i]){

                    $_count;

                    if(is_array($prize['count'])){                        

                        if($i < count($prize['count'])){

                            $_count = $prize['count'][$i];
                        }else{
                            
                            $_count = end($prize['count']);
                        }
                        

                    }else{
                        $_count = $prize['count'];
                    }
                    

                    $item = array(
                        'item'      =>      $prize['item'],
                        'count'     =>      $_count
                    );

                    $this->rewards[] = $item;
                }

            }
                           
            
        }
        
    }

    public function get(){        
        $this->process();
        return $this->rewards;
    }
}


$r = new Reward(1);

print_r($r->get());