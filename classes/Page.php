<?php
class Page{
    public $title;
    public $shortTitle;
    public $category;
    public $content;
    public $tamilContent;
    public $pageType;
    public $list;
    public $pid;
    public $aDatabaseManager;
    public $webPage;
    public $language;
    public $searchKeyword;
    public $tamilTitle;
    public function __construct($param,$request){
        $aView = new View();
        if(is_array($param)){
            $this->tamilTitle = $param['tamilTitle'];
            $this->pid = $param['pid'];
            $this->title = $param['title'];
            $this->shortTitle=$param['shortTitle'];
            $this->content = $param['content'];
            $this->tamilContent = $param['tamilContent'];
            $this->pageType = $param['pageType'];
            $this->searchKeyword=$param['searchKeyword'];
        }
        else if(is_object($param)){
            $this->tamilTitle = $param->tamilTitle;
            $this->pid = $param->pid;
            $this->title = $param->title;
            $this->shortTitle = $param->shortTitle;
            $this->content = $param->content;
            $this->pageType = $param->pageType;
            $this->searchKeyword=$param->searchKeyword;
            $this->tamilContent = $param->tamilContent;
        }
        else if(is_string($param)){
                //echo "<br/>PID is a string";
                $dbInfo = Config::getMySQLInfo();
                $aDatabaseManager = new databaseManager($request,$dbInfo["dbHost"],$dbInfo["dbPassword"],$dbInfo["dbUserName"],$dbInfo["dbName"]);
                $aPage = $aDatabaseManager->findPageInformationByPid($param);
            
                if($aPage->language == "tamil"){
                    $this->content = $aPage->tamilContent;
                    $this->title = $aPage->tamilTitle;
                }
                else{
                    $this->content =$aPage->content;
                    $this->title = $aPage->title;

                }
                $this->pid = $aPage->pid;
                $this->shortTitle = $aPage->shortTitle;
                $this->pageType = $aPage->pageType; 
                $this->searchKeyword=$aPage->searchKeyword;
        }
       
    }
    public function getLanguage(){return $this->language;}
    public function getPid(){return $this->pid;}
    public function getContent(){return $this->content;}
    public function getTamilContent(){return $this->tamilContent;}
    public function getTitle(){return $this->title;}
    public function getTamilTitle(){return $this->tamilTitle;}
    public function getPageType(){return $this->pageType;}
    public function getShortTitle(){return $this->shortTitle;}   
    public function getSearchKeyword(){return $this->searchKeyword;}
}
?>