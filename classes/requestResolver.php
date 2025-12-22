<?php
class requestResolver{
    private $pid;
    private $aView;
    private $request;
    private $tagResolver;
    public function __construct($req){
            $this->request = $req;
            $this->pid=$req['pid'];
            $this->process();
    } 
    public function process(){
      $this->aView = new View();
      $aWebSite = new webPage($this->pid,$this->request);
      $webPageStr = $aWebSite->parse();
      $this->aView->showWebPage($webPageStr);
    }
}
?>