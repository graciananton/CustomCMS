<?php
class languageHandler{
    private $request;
    public function __construct($request){
        $this->request=$request;
    }
    public function decideLanguage(){
        $pid=$request['pid'];
        $language = $request['lang'];
        if($language == "tamil"){
            return $language;
        }
        else{
            return $request;
        }
    }
}