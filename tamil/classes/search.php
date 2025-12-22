<?php
class Search{
    private $request;
    private $aDatabaseManager;
    public function __construct($request){
        $this->request= $request;
        $this->aDatabaseManager = new databaseManager(Config::$dbInfo["dbHost"],Config::$dbInfo["dbPassword"],Config::$dbInfo["dbUser"],Config::$dbInfo["dbName"]);

    }
    public function search(){
        foreach($this->request as $key=>$value){
            if($key=="search"){
                //echo "Searching";
                $contentFiles =$this->aDatabaseManager->findContentFiles($value);

                $matchList = $this->findMatches($this->request['search'],$contentFiles);
                //usort($matchList,$this->rankPages())
                $organizedList = $this->rankPages($matchList);
                /*echo "<pre>";
                print_r($organizedList);
                echo "</pre>";*/
                return $organizedList;
            }
            else{
                return $this->request;
            }
        }
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
 
        $content = "<div style='font-size:20px'>".count($request)." தேடல் முடிவுகள் கிடைத்தன.</div>";
        for($i=0;$i<count($request);$i++){
            $page = $request[$i];
            //$page->content = htmlentities($page->content);
            $pageContent = substr($page->content,20,40);
           $content .="<div>
                        <a href='index.php?pid=".$page->pid."' target ='_blank' style='color:#C41E3A;font-size:20px;'>".$page->title." | சர்ச் ஆஃப் கிரேஸ், ஒட்டாவா</a>
                        <br/><br/>
                       </div>";
        }

        return $content;
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
            $contentList[$i] = $list;
            $matchCounter = 0;
        }
        return $contentList;
        
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