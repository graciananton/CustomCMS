<?php
class Sermon{
    private $mediaList;
    private $condition;
    private $aManager;
    private $request;
    private $id;
    public function __construct($mediaList,$request){
        $this->mediaList = $mediaList;
        $this->id = 1;
        if(array_key_exists('id',$request)){
            $this->id = $request['id'];
        }
        $this->request = $request;
        $dbInfo = Config::getMySQLInfo();
        $this->aManager = new databaseManager($request,$dbInfo["dbHost"],$dbInfo["dbPassword"],$dbInfo["dbUserName"],$dbInfo["dbName"]);
    }

    public function processMedia(){
        if($this->mediaList['submit']=="submitVideo" || $this->mediaList['submit']=='submitTamilVideo'){
            $this->aManager->insertMedia($this->mediaList);
        }
        if($this->mediaList['submit']=="updateVideo"){
            $this->aManager->updateMedia($this->mediaList);
        }
        if($this->mediaList['req']=="delete"){
            $this->aManager->deleteMedia($this->mediaList);
        }
    }
    public function findSearchResultSet($sermonResults,$request){
        $requestYear  = $request['year'];
        $requestMonth = $request['month'];
        $requestCategory = $request['category'];
        $resultSet = array();
        for($i=0;$i<count($sermonResults);$i++){
            $sermonObject = $sermonResults[$i];
            $uploadedDate = $sermonObject->uploadedDate;
            $uploadedCategory = $sermonObject->category;
            $uploadedDateList = explode("-",$uploadedDate);
            $uploadedYear = $uploadedDateList[0];
            $uploadedMonth =$uploadedDateList[1];
          
            /*echo "REQUEST YEARS AND MONTHS:<br/>";
            echo $requestYear."<br/>";
            echo $requestMonth."<br/>";
            echo "UPLOADED YEARS AND MONTH<br/>";
            echo $uploadedYear."<br/>";
            echo $uploadedMonth."<br/>";
            echo "<pre>";
            print_r($sermonObject);
            echo "</pre>";
*/
            if(!empty($requestYear) && !empty($requestMonth) && $requestCategory != "--"){
                if($requestYear == $uploadedYear && $requestMonth == $uploadedMonth && $requestCategory == $uploadedCategory){
                   // echo "Request Year == uploaded year, request month == uploaded month";
                    array_push($resultSet, $sermonObject);
                }
                else{
                }
            }
            if(!empty($requestYear) && $requestMonth == "--" && $requestCategory!="--" ){
                if($requestYear == $uploadedYear && $requestCategory == $uploadedCategory){
                    array_push($resultSet,$sermonObject);
                }
            }
            if(!empty($requestYear) && empty($requestMonth) && $requestCategory == "--"){
                if($requestYear == $uploadedYear){
                 //   echo "Request Year == uploaded year";
                    array_push($resultSet, $sermonObject);
                }
                else{
                }
            }
            
            if(!empty($requestYear) && !empty($requestMonth) && $requestCategory == "--"){
                if($requestMonth=="--" && $requestYear == $uploadedYear){
                   // echo "Empty request Month";
                    array_push($resultSet,$sermonObject);
                }
                if($requestMonth !="--" && $requestYear == $uploadedYear){
                    array_push($resultSet,$sermonObject);
                }
                else{

                }
            }

        
        }
        return $resultSet;
    }
    public function getCategories($sermonResults){
        $sermonCategories = array();
        for($i=0;$i<count($sermonResults);$i++){
            $sermon = $sermonResults[$i];
            $sermonCategory = $sermon->category;
            array_push($sermonCategories,$sermonCategory);
        }
        $sermonCategories = array_values(array_unique($sermonCategories));
        return $sermonCategories;

    }
    public function createOptionList($categories){
        $optionList = "<option value = '--'>--</option>";
        for($i=0;$i<count($categories);$i++){
            $optionList .="<option>".$categories[$i]."</option>";
        }
        return $optionList;
    }
    public function showSermonPage(){
        
        $sermonResults = $this->aManager->findSermonResults();
        
        $categories = $this->getCategories($sermonResults);
        $optionList = $this->createOptionList($categories);
        if($this->request['lang']=="tamil"){
            $sermonPage=$this->findLatestSermon().$this->showSeveralSermons('tamil');
        }
        else{
            $sermonPage=$this->findLatestSermon().$this->showSeveralSermons('');
        }
        return $sermonPage;
    }
    public function findLatestSermon(){
        $sermonResults = $this->aManager->findSermonResults();
        //print_r($sermonResults);
        if(count($sermonResults)>0){
            $latestSermonIndex = count($sermonResults)-1;
            $latestSermonUrl = $sermonResults[$latestSermonIndex]->webAddress;
            $embedSermonUrl = $this->getYouTubeEmbedLink($latestSermonUrl);
            if($this->id != "1"){
                //do nothing
            }
            else{
                $latestSermon ="<h2 id='latestSermonTitle'>Last Week's Sermon:</h2>
                <iframe src=".$embedSermonUrl."  style='height:625px;margin:auto;' id='latestSermon' allowfullscreen></iframe>";
            }
        
            return $latestSermon;
        }
        else{
            $emptyString ="";
            return $emptyString;
        }
    }
    public function showSeveralSermons($lang){
        $sermons = $this->aManager->findSermonResults();
        $sermons = array_reverse($sermons);
        array_shift($sermons);

        if($this->id != "1"){
            $sermonIframeList = "<div id='unitCount'>Page Number: ".$this->id."</div>";
            
        }
        $sermonIframeList .= "<div id='messagesTitle'>Watch All Messages</div>";
        $sermonCount = count($sermons);
        
        $groups = array_chunk($sermons, 4);
        $group = $groups[($this->id)-1];

      
        //echo "</pre>";


        for($i=0;$i<4;$i++){
            $sermon = $group[$i];
            $embededLink = $this->getYoutubeEmbedLink($sermon->webAddress);
            if(filter_var($embededLink, FILTER_VALIDATE_URL)){
                $sermonIframeList .= "<iframe src=".$embededLink." id='sermons' style='height:450px;' allowfullscreen></iframe>";
            }
            else{
                //youtube link is invalid
            }
        }
        if(count($groups)>=1){
            $sermonIframeList .= $this->createPaginationBar($sermonCount,$lang);
        }
        else{
            //don't create a PaginationBar
        }
        return $sermonIframeList;
    }
    public function createPaginationBar($sermonCount,$lang){
        $paginationUnit = $sermonCount/4;

        $paginationUnit = ceil($paginationUnit);
        $previousId = $this->id-1;
        $nextId = $this->id+1;
    
        $sermonIframeList = "<ul id='paginationBar'>";
        if($this->id !="1"){
            $sermonIframeList .="<li><a href=?req=paginationItem&pid=420&id=".$previousId."&lang=".$lang."><-- Previous</a></li>";

        }
        else{
            //don't built the previous statement
        }
        for($i=1;$i<=$paginationUnit;$i++){
            if($i==$this->id){
                $sermonIframeList .="<li id=".$i."><a href=?req=paginationItem&pid=420&id=".$i."&lang=".$lang." style='color:red;'>".$i."</a></li>";

            }
            else{
                $sermonIframeList .="<li id=".$i."><a href=?req=paginationItem&pid=420&id=".$i."&lang=".$lang.">".$i."</a></li>";

            }
        }
        if($this->id != $paginationUnit){
            $sermonIframeList .= "<li><a href=?req=paginationItem&pid=420&id=".$nextId."&lang=".$lang.">Next --></a></ul>";
        }
        else{
            //don't built a next statement
            $sermonIframeList .="</ul>";
        }
        return $sermonIframeList;
    }
    function getYouTubeEmbedLink($watchLink) {
        // Parse the video ID from the watch link
        parse_str(parse_url($watchLink, PHP_URL_QUERY), $queryParams);
        $videoID = $queryParams['v'] ?? null;
    
        // Check if video ID is valid
        if (!$videoID) {
            return "Invalid YouTube link.";
        }
    
        // Construct and return the embed link
        return "https://www.youtube.com/embed/$videoID";
    }
    public function showSearchResult($request){
          //  print_r($request);
            $size = count($this->mediaList);
            $row="";
            for($i=0;$i<$size;$i++){
                $obj = $this->mediaList[$i];
                if($obj){     
                    $row .="<tr>
                                <td>".$obj->uploadedDate."</a></td>
                                <td><a target='_blank' href=".$obj->webAddress.">".$obj->webAddress."</a></td>
                                <td>".$obj->title."</td>
                                <td style='padding:35px;'>".$obj->givenBy."</td>
                                <td style='padding:35px;'>".$obj->category."</td>
                                <td style='padding:20px;'><a target='_blank' href=".$obj->notes.">Sermon Notes</a></td>
                           </tr>";                 
                }
            }
        echo "</table>";
        if(count($this->mediaList)>0){
            $sermonTable = "<table>
                        <tr>
                            <th>Uploaded Date:</th>
                            <th>Web Address:</th>
                            <th>Title:</th>
                            <th>Given By:</th>
                            <th>Category:</th>
                            <th>Sermon Notes:</th>
                        </tr>
                        ".$row."
                        </table>
                        <script>
                        hideLatestSermon();
                        hideLatestSermonTitle();
                        function hideLatestSermon() {
                            document.getElementById('latestSermon').style.display = 'none';
                            document.getElementById('messagesTitle').style.display = 'none';
                            let sermons = document.querySelectorAll('#sermons');
                            sermons.forEach(function(sermon) {
                                sermon.style.display = 'none';
                            });
                            document.getElementById('paginationBar').style.display = 'none';    
                        }
                        function hideLatestSermonTitle(){
                            document.getElementById('latestSermonTitle').style.display = 'none';
                        }
                        </script>
                        ";
        }
        else{
            $sermonTable="<div style='color:red;font-size:30px;'>No Results found</div><br/>
                            <script>
                        hideLatestSermon();
                        hideLatestSermonTitle();
                        function hideLatestSermon() {
                            document.getElementById('latestSermon').style.display = 'none';
                            document.getElementById('sermons').style.display='none';
                            document.getElementById('messagesTitle').style.display = 'none';
                            let sermons = document.querySelectorAll('#sermons');
                            sermons.forEach(function(sermon) {
                                sermon.style.display = 'none';
                            });
                            document.getElementById('paginationBar').style.display = 'none';    
                        }
                
                        function hideLatestSermonTitle(){
                            document.getElementById('latestSermonTitle').style.display = 'none';
                        }
                        </script>
                        ";
        }
        return $sermonTable;
    }   
}