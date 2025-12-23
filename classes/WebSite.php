<?php
class webPage extends Page{ 
    public $template;
    private $TEMPLATE_ID="388";

    public $header;
    private $HEADER_ID='385';

    private $banner;
    private $BANNER_ID='376';

    private $navBar;
    private $NAVBAR_ID='377';
    
    public $title;

    public $content;
    private $CONTENT_ID="";
    
    private $CONTACT_ID = "100";

    private $blog;
    private $BLOG_ID="1";

    private $contentScript;
    private $CONTENTSCRIPT_ID='387';
    
    private $footer;
    private $FOOTER_ID='382';

    private $webPageStr;
    public $pid;
    private $errorPage;
    public $tagResolver;
    private $request;
    private $aView;
    private $array;
    private $msg;
    private $organizedList;
    private $id;
   // private $aDatabaseManager;
    public function __construct($pid,$request){
            $this->request = $request; 
         
            $this->pid=$pid;
          //  print_r($this->request);
          $dbInfo = Config::getMySQLInfo();
          $aDatabaseManager = new databaseManager($this->request,$dbInfo["dbHost"],$dbInfo["dbPassword"],$dbInfo["dbUserName"],$dbInfo["dbName"]);
           // $aDatabaseManager = new databaseManager($this->request,Config::$dbInfo["dbHost"],Config::$dbInfo["dbPassword"],Config::$dbInfo["dbUser"],Config::$dbInfo["dbName"]);
           $aSearch = new Search($request);

           $webAnalytics = new webAnalytics($request);
           
           $organizedList = $aSearch->search();
           if(array_key_exists("search",$request)){
              $this->pid = "5";
             $this->request = $organizedList;
            }
            $this->id="";
            if(array_key_exists('id',$request) & $request['pid']=="420"){
                $this->id = $request['id'];
            }
            $this->CONTENT_ID = $this->pid;
            $server_name = $_SERVER['REMOTE_ADDR'];
            //$aDatabaseManager->store_ip_address($server_name);
            $this->setPageComponents();
    }

    private function setPageComponents(){
        $this->setTemplate();
        $this->setHeader();
        $this->setNavBar();
        $this->setChristmasHolidays();
        $this->setBanner();
        $this->setFooter();
        $this->setScript();
        $this->setBlog();

        $this->setContent();
        $this->setTitle();

    }
    private function setChristmasHolidays(){
        $this->christmasHolidays = new Page(Config::$pageComponents['christmasHolidays'],$this->request);
        $this->webPageStr = str_replace("#COG_CHRISTMASHOLIDAYS",$this->christmasHolidays->content,$this->webPageStr);
    }
    private function setTemplate(){
        $this->template = new Page(Config::$pageComponents['template'],$this->request);
        $this->webPageStr = $this->template->content;
    }
    private function setHeader(){
        
        $this->header   = new Page(Config::$pageComponents['header'],$this->request);
        $this->webPageStr = str_replace("#COG_HEADER",$this->header->content,$this->webPageStr);


    }
    private function setBlog(){
        $this->blog = new Page(Config::$pageComponents['blog'],$this->request);
        $this->webPageStr = str_replace("#COG_BLOG",$this->blog->content,$this->webPageStr);

    }
    private function setNavBar(){
        $this->navBar = new Page(Config::$pageComponents['navbar'],$this->request);
        $this->webPageStr = str_replace("#COG_NAVBAR",$this->navBar->content ,$this->webPageStr);

    }
    private function setBanner(){
        $this->banner = new Page(Config::$pageComponents['banner'],$this->request);

        $this->webPageStr = str_replace("#COG_BANNER",$this->banner->content ,$this->webPageStr);

    }
    private function setContent(){
        $this->content = new Page($this->CONTENT_ID,$this->request);
        
        if(empty($this->content->content)){
            $this->errorPage = new Page(Config::$errorPage,$this->request);
            $this->webPageStr =str_replace("#COG_PAGECONTENT",$this->errorPage->content,$this->webPageStr);


            $this->tagResolver = new tagResolver($this->webPageStr,$this->request);
            $this->webPageStr = $this->tagResolver->process(); 

            $this->title = $this->content->title;
            $this->webPageStr = str_replace("#COG_TITLE","<h2>".$this->title."</h2>" ,$this->webPageStr);
    

        }
        else if(array_key_exists("pid",$this->request) && array_key_exists("year",$this->request) && array_key_exists("month",$this->request) /*&& array_key_exists("day",$this->request)*/)
               {
             //  echo "PId";
             //  echo "<pre>";
              // print_r($this->request);
              // echo "</pre>";
                $dbInfo = Config::getMySQLInfo();

                $aDatabaseManager = new databaseManager($this->request,$dbInfo["dbHost"],$dbInfo["dbPassword"],$dbInfo["dbUserName"],$dbInfo["dbName"]);

                $aSermon = new Sermon("",$this->request);

                $sermonResults=$aDatabaseManager->findSermonResults();

                $searchResultSet = $aSermon->findSearchResultSet($sermonResults,$this->request);
              
                $aSermon = new Sermon($searchResultSet,$this->request);
                $sermonTable = $aSermon->showSearchResult($this->request);
                $this->webPageStr = str_replace("#COG_PAGECONTENT",$aSermon->showSermonPage().$sermonTable,$this->webPageStr);
             
                }
        else{
            $this->webPageStr = str_replace("#COG_PAGECONTENT",$this->content->content,$this->webPageStr);
            $this->tagResolver = new tagResolver($this->webPageStr,$this->request);
            $this->webPageStr = $this->tagResolver->process(); 

        }

    }

    private function setTitle(){
        $this->title = $this->content->title;
        $this->webPageStr = str_replace("#COG_TITLE","<h2>".$this->title."</h2>" ,$this->webPageStr);

    }
    private function setFooter(){
       // echo "Setting Footer";
        $this->footer = new Page(Config::$pageComponents['footer'],$this->request);

        $this->webPageStr = str_replace("#COG_FOOTER",$this->footer->content ,$this->webPageStr);
    }
    private function setScript(){
     ///   echo "Setting Script";
        $this->contentScript = new Page(Config::$pageComponents['contentScript'],$this->request);
        $this->webPageStr = str_replace("#COG_IMAGESCRIPT",$this->contentScript->content ,$this->webPageStr);
    }
    
    public function parse(){
        $this->webPageStr = htmlspecialchars_decode($this->webPageStr, ENT_QUOTES);
        return $this->webPageStr;
    }
}
?>