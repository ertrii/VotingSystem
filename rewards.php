<?php

class Reward {
    
    private $vote;
    private $additionalVote = false;

    function __construct($_vote, $_additionalVote = false){        
        $this-> vote = intval($_vote);
        if($_additionalVote) $this-> additionalVote = intval($_additionalVote);
    }

    private $rewards = array();

    private function countItem($prize, $i){
        $_quantity;

        if(is_array($prize['quantity'])){                        

            if($i < count($prize['quantity'])){
                
                if(is_array($prize['quantity'][$i])){
                    $_quantity = rand($prize['quantity'][$i]['min'], $prize['quantity'][$i]['max']);
                }else{
                    $_quantity = $prize['quantity'][$i];                    
                }
            }else{
                
                if(is_array(end($prize['quantity']))){
                    $_quantity = rand(end($prize['quantity'])['min'], end($prize['quantity'])['max']);
                }else{
                    $_quantity = end($prize['quantity']);
                }
                
            }
                        

        }else{
            $_quantity = $prize['quantity'];
        }
                    

        return array(
            'item'          =>      $prize['item'],
            'quantity'      =>      $_quantity
        );
    }

    private function process(){
                        
        foreach (Items::get() as $prize) {
            if(!$prize['status']) continue;
            
            $_itemTemporal = null;

            for ($i=0; $i < count($prize['voteRequerid']); $i++) {

                switch ($prize['type']) {
                    case 'continuous':
                    case 'c':                        
                        if($this->vote >= $prize['voteRequerid'][$i])
                            $_itemTemporal = $this->countItem($prize, $i);                            
                        break;

                    case 'requerid':
                    case 'r':
                        if($this->vote === $prize['voteRequerid'][$i]){
                            $this->rewards[] = $this->countItem($prize, $i);
                            break 2;
                        }
                        break;

                    case 'accumulate':
                    case 'a':
                        if(!$this->additionalVote){
                            $this->rewards[] = array("item" => array('id' => -1, 'name' => 'error: The additional vote is needed', 'img' => 'error.png'), 'quantity' => null) ;
                            break 2;
                        }
                        
                        if($this->additionalVote === $prize['voteRequerid'][$i]){
                            $this->rewards[] = $this->countItem($prize, $i);
                            break 2;
                        }
                        break;
                        
                    default:
                        $this->rewards[] = array("item" => array('id' => -1, 'name' => 'error type', 'img' => 'error.png'), 'quantity' => null) ;
                        break 2;
                }
            }
            //print_r($_itemTemporal);            
            if($prize['type'] === 'continuous' || $prize['type'] === 'c') {                
                if($_itemTemporal !== null){
                    $this->rewards[] = $_itemTemporal;
                    $_itemTemporal = null;
                }                
            } 
            
        }
        
    }

    public function get(){        
        $this->process();        
        return $this->rewards;
    }
}