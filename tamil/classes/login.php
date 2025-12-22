<?php
class loginPage{
    private $_REQ;
    private $code;
    private $username="basil_anton@yahoo.ca";
    private $password="78Agracian";
    public function __construct($request){
        $this->_REQ=$request;
        if(
            $this->isSetSessionAuth() && 
            $this->isValidSessionAuth()
        )
        {
            $this->code="";
        }
        else if(
            $this->isValidReqAuth() &&
            $this->isSetReqAuth() && 
            !($this->isSetSessionAuth())
        )
        {
            $this->code = "";
            $_SESSION['username']=$username;// or set equal to 'test'
            $_SESSION['password']=$password;// or set equal to 'test'
        }
        else if(!isset($_SESSION['username'])){
            $this->code="";
            header("Location: login.php?e=invalid");
            die();
        }
    }
    private function isValidReqAuth(){
        if($this->_REQ['username'] =='basil_anton@yahoo.ca' && $this->_REQ['password']=='78Agracian'){
            return true;
        }
        else{
            return false;
        }
    }
    private function isSetReqAuth(){
        if(isset($this->_REQ['username']) && isset($this->_REQ['password'])){
            return true;
        }
        else{
            return false;
        }
    }
    private function isValidSessionAuth(){
        if($_SESSION['username'] =='basil_anton@yahoo.ca' && $_SESSION['password'] =='78Agracian'){
            return true;
        }
        else{
            return false;
        }
    }
    private function isSetSessionAuth(){
        if(isset($_SESSION['username']) && isset($_SESSION['password'])){
            return true;
        }
        else{
            return false;
        }
    }










    //
    /*
    private setSession(){
        if(isset($_SESSION['username']) &&
            isset($_SESSION['password']) &&
            $_SESSION['username'] =='test' &&
            $_SESSION['password'] =='test'
           ){
             $_SESSION['username']=$_REQ['username'];// or set equal to 'test'
             $_SESSION['password']=$_REQ['password'];// or set equal to 'test'
           }
    }
    */
    public function display(){

        $favcolor = "red";

        switch ($this->code) {
        case "100": 
            echo "Your favorite color is red!";
            break;
        case "blue":
            echo "Your favorite color is blue!";
            break;
        case "green":
            echo "Your favorite color is green!";
            break;
        default:
            echo "Your favorite color is neither red, blue, nor green!";
        }

    }
}
?>