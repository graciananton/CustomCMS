<?php
class validateInput{
    private $list;
    function __construct($list){
        $this->list=$list;
    }
    public function validateInput(){
        //print_r($this->list);
        if(is_array($this->list)){
            if(count($this->list)<8){
               foreach($this->list as $key => $value){
                    //echo $value."<br/><br/>";
                    $value=stripslashes($value);
                    $value=htmlentities($value);
                    $value=strip_tags($value);
                }
                return $this->list;
            }
            else{
                $this->list['pid']=Config::$errorPage;
               // print_r($this->list);
                return $this->list;
            }
        }
        else{
            //print_r($this->list);
            $this->list['pid']=Config::$errorPage;
            return $this->list;
        }
            
    }
}