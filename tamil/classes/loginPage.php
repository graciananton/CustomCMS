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
            $this->code="100";
            $this->display($this->code);
        }
        else if(
            $this->isValidReqAuth() &&
            $this->isSetReqAuth() && 
            !($this->isSetSessionAuth())
        )
        {
            $this->code = "204";
            $this->display($this->code);
            $_SESSION['username']="basil_anton@yahoo.ca";///Config::$loginInfo["username"];// or set equal to 'test'
            $_SESSION['password']="78Agracian";//Config::$loginInfo["password"];// or set equal to 'test'
        }
        else if(!isset($_SESSION['username'])){
            $this->code="404";
            $this->display($this->code);
            header("Location: ../admin/login.php?e=invalid");
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
    public function display($code){

        switch ($code) {
        case "100": 
            echo "<br/>100 - Logged In<br/>";
            break;
        case "204":
            echo "<br/>204 - Logged In After Logging Out<br/>";
            break;
        case "404":
            echo "<br/>404 - Invalid Log In<br/>";
            break;
        default:
            echo "<br/>Error<br/>";
        }

    }
}
?>