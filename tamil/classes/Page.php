<?php
class Page{
    public $title;
    public $shortTitle;
    public $category;
    public $content;
    public $pageType;
    public $list;
    public $pid;
    public $aDatabaseManager;
    public $webPage;
    public $searchKeyword;
    public function __construct($param){
        $aView = new View();
        if(is_array($param)){
            echo "param is an array";
           /* echo "<pre>";
            print_r($param);
            echo "</pre>";*/
            $this->pid = $param['pid'];
            $this->title = $param['title'];
            $this->shortTitle=$param['shortTitle'];
            $this->content = $param['content'];
            $this->pageType = $param['pageType'];
            $this->searchKeyword=$param['searchKeyword'];
        }
        else if(is_object($param)){
            $this->pid = $param->pid;
            $this->title = $param->title;
            $this->shortTitle = $param->shortTitle;
            $this->content = $param->content;
            $this->pageType = $param->pageType;
            $this->searchKeyword=$param->searchKeyword;
        }
        else if(is_string($param)){
                //echo "<br/>PID is a string";
                $aDatabaseManager = new databaseManager(Config::$dbInfo["dbHost"],Config::$dbInfo["dbPassword"],Config::$dbInfo["dbUser"],Config::$dbInfo["dbName"]);

                $aPage = $aDatabaseManager->findPageInformationByPid($param);
        
                $this->pid = $aPage->pid;
                //echo "PID is ".$this->pid;
                $this->title = $aPage->title;
                $this->shortTitle = $aPage->shortTitle;
                $this->content = $aPage->content;
                $this->pageType = $aPage->pageType; 
                $this->searchKeyword=$aPage->searchKeyword;
        }
       
    }
    public function getPid(){return $this->pid;}
    public function getContent(){return $this->content;}
    public function getTitle(){return $this->title;}
    public function getPageType(){return $this->pageType;}
    public function getShortTitle(){return $this->shortTitle;}   
    public function getSearchKeyword(){return $this->searchKeyword;}
}
?>