<?php
class Search{
    private $request;
    private $aDatabaseManager;
    public function __construct($request){
        $this->request= $request;
        $dbInfo = Config::getMySQLInfo();
        $this->aDatabaseManager = new databaseManager($this->request,$dbInfo["dbHost"],$dbInfo["dbPassword"],$dbInfo["dbUserName"],$dbInfo["dbName"]);
       // $this->aDatabaseManager = new databaseManager($this->request,Config::$dbInfo["dbHost"],Config::$dbInfo["dbPassword"],Config::$dbInfo["dbUser"],Config::$dbInfo["dbName"]);

    }
    public function search(){
        foreach($this->request as $key=>$value){
            if($key=="search"){
                $contentFiles =$this->aDatabaseManager->findContentFiles($value);


                $matchList = $this->findMatches($this->request['search'],$contentFiles);
                //usort($matchList,$this->rankPages())
                /* "<pre>";
                print_r($matchList);
                echo "</pre>";*/
                $organizedList = $this->rankPages($matchList);
                return $organizedList;
            }
            else{
                return $this->request;
            }
        }
    }
    function findMatches($searchInput, $contentList) {

        $searchInput = strtolower($searchInput);
        $searchInput = str_replace(' ','',$searchInput);

        $matchCounter = 0;
        for($i=0;$i<count($contentList);$i++){
            $list = $contentList[$i];
            $searchKeyword = explode(",",$list->searchKeyword);
            for($j=0;$j<count($searchKeyword);$j++){
                $searchKeyword[$j]=str_replace(' ','',$searchKeyword[$j]);
                $searchKeyword[$j]=strtolower($searchKeyword[$j]);

                if($searchInput == $searchKeyword[$j]){
                    $matchCounter = $matchCounter+1;
                }
            }
            $list->matchCounter=$matchCounter;
            $list->lang = $this->request['lang'];
            $contentList[$i] = $list;
            $matchCounter = 0;
        }
        return $contentList;
        
    }

    public function findContentFileTitles($contentFiles){
        $contentTitles = array();
        for($i=0;$i<count($contentFiles);$i++){
            $contentFile = $contentFiles[$i];
            $contentTitles[$i]['title'] = $contentFile->title;
            $contentTitles[$i]['content'] = $contentFile->content;
            $contentTitles[$i]['searchKeyword'] = $contentFile->searchKeyword;
            $contentTitles[$i]['pid'] = $contentFile->pid;
        }
        return $contentTitles;
    }
    public function viewSearchResults($request){
        $content = "<div style='font-size:20px'>".count($request)." Search Results Found.</div>";
        for($i=0;$i<count($request);$i++){
            $page = $request[$i];
            $page_content = html_entity_decode($page->content);
            $page_content = strip_tags($page_content); 
            $pageContent = substr($page_content,0,220);
            //$page->content = htmlentities($page->content);
            if($page->lang=="tamil"){
                $content .="
                
               <div>
                <a href='index.php?pid=".$page->pid."&lang=tamil' target ='_blank' style='color:#C41E3A;font-size:20px;'>".$page->tamilTitle." | அன்பின் சின்னம், ஒட்டாவா</a>
                <br/>
                <div style='margin-left:20px;'>".$pageContent."....</div>
               </div>";
            }
            else{
             $content .="
             <div>
                <a href='index.php?pid=".$page->pid."' target ='_blank' style='color:#C41E3A;font-size:20px;'>".$page->title." | Church of Grace, Ottawa</a>
                <br/>
                <div style='margin-left:20px;'>".$pageContent."....</div>
             </div>";
            }
           
        }

        return $content;
    }
    public function rankPages($matchList){
       $organizedList = array();
       $numberList = array();
       for($i=0;$i<count($matchList);$i++){
         if($matchList[$i]->matchCounter > 0){
            array_push($organizedList,$matchList[$i]);
         }
       }
       return $organizedList;
    }
   
}