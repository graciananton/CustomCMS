<?php
class adminDatabaseManager{
    public $con='';
    public $db_host;
    public $db_user;
    public $db_pass;
    public $db_name;
    public function __construct($db_host,$db_pass, $db_user,$db_name){
        $this->db_host = $db_host;
        $this->db_user = $db_user;  
        $this->db_pass = $db_pass;
        $this->db_name = $db_name;
    }
    public function connect(){
        echo "connecting()";
        if (!$this->con) {
            echo "not connecting";
            echo "This is a connection". $this->con;
            $this->con = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
            echo $this->con;
            echo "connecting";
            print_r($this->con);
            if($this->con) {
                $seldb = mysqli_select_db($this->con, $this->db_name);
                if($seldb) {
                    return true; 
                } else {
                    return false;
                }
            } else {
                
                return false;
            }
        } 
        else {
            return true;
        }
        
    }
    public function traverseDbByCategory($categoryChoice){
        echo "traverseDBByCategory() in adminDatabaseManager.php";
        $this->connect();
        $resultSet = array();
        $sql = "SELECT * FROM pagecontent2";
        //$result     = mysql_query($this->con,$sql);
        $result = $this->con->query($sql);

        while ($obj = $result->fetch_object()) {
            if(!empty($obj->pageType) && $obj->pageType == $categoryChoice){
                array_push($resultSet,$obj);
            }    
        }
        $result -> free_result();
        $aView = new View();
        $aView -> createTableBySearchResult($resultSet); 
    }
    public function findContentFiles($searchValue){
        //echo "In databaseManger";
        $contentFiles = array();
        $Files = $this->selectPageContent();
            for($i=0;$i<count($Files);$i++){
                $file = $Files[$i];
                if($file->pageType=="Content"){
                    array_push($contentFiles,$Files[$i]);
                } 
            }  
        /*echo "<pre>";
        print_r($contentFiles);
        echo "</pre>";*/
        return $contentFiles;
    }



    

    /*public function findPageContentByTitle($title){
        $this->connect();
        echo "INside pageconte";
       $resultSet = array();
        $sql= "SELECT * FROM pagecontent2 WHERE  title =".$title;
        $result = $this->con->query($sql);
        while($obj=$result->fetch_object()){
            if($obj->title == $title){
                array_push($resultSet,$obj);
            }
        }
        $result->free_result();
        return $resultSet;
        
    }*/


    public function selectPageContent(){
        $this->connect();
        $sql = "SELECT * FROM pagecontent2";
        $result = $this->con->query($sql);
        $array = array();
        while($row = $result->fetch_object()){
            array_push($array,$row);
        }
        return $array;
    }
    public function select($type){
        $this->connect();

        $sql = "SELECT content FROM pagecontent2 WHERE pageType = '$type'";
        
        $result = $this->con->query($sql);
        $row = $result->fetch_object();
        $result->free_result();
        return $row;
    }
    public function store_ip_address($server_name){
        $this->connect();
        //echo "Storing ip address";
        $ip_addresses = $this->traverse_ip_addresses();
        /*echo "<pre>";
        print_r($ip_addresses);
        echo "</pre>";*/
        $result = $this->match_ip_address($ip_addresses,$server_name);
        //echo $result;
        
        if($result==""){
            $this->insert_ip_address($server_name);
        }
        else{
            return false;
        }
    }

    public function traverse_ip_addresses(){
        $this->connect();
        $sql = "SELECT ip_address,date_Inserted,pid FROM ip_addresses";
        $resultSet = array();
        //$sql = "SELECT * FROM pagecontent2";
        //$result     = mysql_query($this->con,$sql);
        $result = $this->con->query($sql);
        while ($obj = $result->fetch_object()) {
                array_push($resultSet,$obj);
        }
        $result -> free_result();
        return $resultSet;
    }
    private function match_ip_address($ip_addresses,$server_name){
        $this->connect();
        $counter = "";
        for($i=0;$i<count($ip_addresses);$i++){
            $ip_address_list= $ip_addresses[$i];
            $ip_address = $ip_address_list->ip_address;
            if($ip_address == $server_name){
                $counter = '1';
                return $counter;
            }
        }
        return $counter;
    }
    private function insert_ip_address($server_name){
        $this->connect();
        $date = date('F j, Y g:i A');
        $sql = "INSERT INTO ip_addresses(ip_address,date_Inserted) VALUES ('$server_name','$date')";
        $command = mysqli_query($this->con,$sql);
        
    }


    public function insert($aPage){
      //  echo "Successfully Inserted";
      echo "inserting";
        $this->connect();
        echo "<pre>";
        print_r($aPage);
        echo "</pre>";
        $searchKeyword= $aPage->getSearchKeyword();
        $searchKeyword =str_replace("'", "\\'", $searchKeyword);
       echo "<br/><br/>".$searchKeyword."<br/>";

        $title= $aPage->getTitle();
       echo "<br/><br/>".$title."<br/>";
        $title =str_replace("'", "\\'", $title);
        $shortTitle = $aPage->getShortTitle();
        $shortTitle=str_replace("'", "\\'", $shortTitle);
       echo "<br/>".$shortTitle."<br/>";
        $content = $aPage->getContent();
        $content = str_replace("'", "\\'", $content);
        echo "<br/>".$content."<br/>";
        $tamilContent = $aPage->getTamilContent();
        $tamilContent = str_replace("'","\\",$tamilContent);
        $pageType = $aPage->getPageType();
        $pageType = str_replace("'", "\\'", $pageType);
        echo "<br/>".$pageType."<br/>";
        
        if($this->checkTitle($title)){

            $sql = "INSERT INTO pagecontent2(content,tamilContent,searchKeyword,title,shortTitle, pageType) VALUES ('$content','$tamilContent','$searchKeyword','$title','$shortTitle','$pageType')";
            
            $command = mysqli_query($this->con,$sql) or die("Bad query");
            return true;
        }
        else{
            return false;
        }    

    }
    public function findUploadedDates(){
        $this->connect();
        $selection = "SELECT uploadedDate,pid FROM sermons";
        $result    = mysqli_query($this->con,$selection) or die("bad query");
        $row       = mysqli_fetch_all($result);
        $searchOutput=array();
        for($i=0;$i<count($row);$i++){
            array_push($searchOutput,$row[$i][0]);
        }
        return $searchOutput;
    }
    
    private function checkTitle($title){
        $selection = "SELECT title FROM pagecontent2 ";
        $result    = mysqli_query($this->con,$selection) or die ("bad query");
        $row       = mysqli_fetch_all($result);
        for($i=0;$i<count($row);$i++){
           
           if($title ==  $row[$i][0]){
            return false;
           }
        }
        return true;
    }
    
    
    public function insertMedia($aMediaList){
        
        $this->connect();
        $uploadedDate =$aMediaList['uploadedDate'];
        $videoUrl = $aMediaList['videoAddress'];
        $title = $aMediaList['title'];
        $title = str_replace("'", "\\'", $title);
        $givenBy = $aMediaList['givenBy'];
        $givenBy = str_replace("'",'\\',$givenBy);
        $notes=$aMediaList['notes'];
        $notes = str_replace("'", "\\'", $notes);
        $sql = "INSERT INTO sermons(title,uploadedDate,notes,webAddress,givenBy) VALUES('$title','$uploadedDate','$notes','$videoUrl','$givenBy')";
        $command = mysqli_query($this->con,$sql);
    }
    public function updateMedia($aMediaList){
        $this->connect();
        $videoUrl = $aMediaList['videoAddress'];

        $dateUploaded = $aMediaList['uploadedDate'];

        $notes = $aMediaList['notes'];
        $notes = str_replace("'", "\\'", $notes);
        $title =$aMediaList['title'];
        $title =str_replace("'", "\\'", $title);
        $givenBy = $aMediaList['givenBy'];
        $givenBy=str_replace("'","\\",$givenBy);
        $pid = $aMediaList['pid'];

        $sql = "UPDATE sermons 
        SET uploadedDate = '$dateUploaded',
            webAddress    = '$videoUrl',
            notes        = '$notes',
            title        ='$title',
            givenBy      ='$givenBy'
        WHERE pid = '$pid'";
        
    
        if($this->con->query($sql)==TRUE){
            echo "Successfully Updated";
        }
        else{
            echo "Information has not been updated";
        }
    }
    public function update($aPage){
        $this->connect();
        $searchKeyword= $aPage->getSearchKeyword();
        $searchKeyword =str_replace("'", "\\'", $searchKeyword);

        $content = $aPage->getContent();
        $content = str_replace("'", "\\'", $content);
        $title = $aPage->getTitle();
        $title = str_replace("'", "\\'", $title);
        $shortTitle=$aPage->getShortTitle();
        $shortTitle = str_replace("'", "\\'", $shortTitle);
        $pageType = $aPage->getPageType();
        $pid      = $aPage->getPid();

        $sql = "UPDATE pagecontent2 
        set content = '$content',
            searchKeyword = '$searchKeyword',
            title          = '$title',
            shortTitle     = '$shortTitle',
            pageType       = '$pageType'
        WHERE pid = '$pid'";
        
        
    
        if($this->con->query($sql)==TRUE){
            echo "Successfully Updated";
        }
        else{
            echo "Information has not been updated";
        }
       
    }
    public function findSermonResults(){
        if($this->request['lang']=="tamil"){
            $this->connect();
            $resultSet = array();
            $sql = "SELECT * FROM tamilsermons";
            $result = $this->con->query($sql);
            while($obj = $result->fetch_object()){
                array_push($resultSet,$obj);
            }
            $result->free_result();

        }
        else{
            $this->connect();
            $resultSet = array();
            $sql = "SELECT * FROM sermons";
            $result = $this->con->query($sql);
            while($obj = $result->fetch_object()){
                array_push($resultSet,$obj);
            }
            $result->free_result();
        }
        return $resultSet;
    }
    public function deleteMedia($aMediaList){
        $this->connect();
        $sql = "DELETE FROM sermons WHERE pid=".$aMediaList['pid'];
        if($this->con->query($sql) === TRUE){
            echo "Data has been successfully deleted";
        }
        else{
            echo "Data has been unsuccessfully deleted";
        }
    }
    public function findSermonPageInformationByPid($pid){
        $this->connect();
        $sql = "SELECT pid,title,uploadedDate, notes, webAddress,givenBy FROM sermons WHERE pid =".$pid;
        
        $result = $this->con->query($sql);
        $row = $result->fetch_object();
        $result -> free_result();
        return $row;
    }


 
    public function findPageContentByPid($pid){
        $this->connect();

            $sql = "SELECT content FROM pagecontent2 WHERE pid=".$pid;
        
        $result=$this->con->query($sql);
        $row = $result->fetch_object();
        $result->free_result();
        if(htmlspecialchars($row->content, ENT_QUOTES, 'UTF-8')){
            $row->content =htmlspecialchars($row->content, ENT_QUOTES, 'UTF-8');
        }
        return $row;
    }
    public function findMatchingRow($pid){
        $this->connect();
        $resultSet = array();
        $sql= "SELECT * FROM pagecontent2 WHERE  pid =".$pid;
        $result = $this->con->query($sql);
        while($obj=$result->fetch_object()){
            if($obj->pid == $pid){
                array_push($resultSet,$obj);
            }
        }
        $result->free_result();
        return $resultSet;
        
    }/*
    public function update($aPage){
        $this->connect();
        $content = $aPage->getContent();
        $title = $aPage->getTitle();
        $shortTitle=$aPage->getShortTitle();
        $pageType = $aPage->getPageType();
        $pid      = $aPage->getPid();
        $sql = "UPDATE pagecontent2 
        set content = '$content',
            title          = '$title',
            shortTitle     = '$shortTitle',
            pageType       = '$pageType'
        WHERE pid = '$pid'";
        
    
        if($this->con->query($sql)==TRUE){
            echo "Successfully Updated";
        }
        else{
            echo "Information has not been updated";
        }
       
    }*/
    public function findPageInformation($list){
        $this->connect();
        $pid = $list['pid'];

            $sql = "SELECT  pid,content, title, searchKeyword, shortTitle, pageType FROM pagecontent2 WHERE pid =".$pid;
        
        $result = $this->con->query($sql);
        $row = $result->fetch_object();
        $result -> free_result();
        return $row;
    }
    
    
    
    
    public function findPageInformationByTitle($title){
        $this->connect();
        $sql = "SELECT pid,content, searchKeyword, title, shortTitle, pageType FROM pagecontent2 WHERE title = '$title'";
        
        $result = $this->con->query($sql);
        
        $row = $result->fetch_object();
        $result -> free_result();
        return $row;
    }
    public function delete($list){
        $this->connect();
        $sql = "DELETE FROM pagecontent2 WHERE pid=".$list['pid'];
        if($this->con->query($sql) === TRUE){
            echo "Data has been successfully deleted";
        }
        else{
            echo "Data has been unsuccessfully deleted";
        }
    }

   
    public function findPageComponentByCategory($title){
        $this->connect();

        $sql = "SELECT content FROM pagecontent2 WHERE title = '$title'";
        
        $result = $this->con->query($sql);
        $row = $result->fetch_object();
        $result->free_result();
        return $row;
    }
    public function insertEventDate($eventList){
        $this->connect();

        $eventDate =$eventList['eventDate'];
        $eventDate = str_replace("'", "\\'", $eventDate);

        $eventTitle = $eventList['eventTitle'];
        $eventTitle = str_replace("'", "\\'", $eventTitle);

        $eventDescription = $eventList['eventDescription'];
        $eventDescription = str_replace("'", "\\'", $eventDescription);
        
        $sql = "INSERT INTO eventCalendar(eventDate,eventTitle,eventDescription) VALUES('$eventDate','$eventTitle','$eventDescription')";
        $command = mysqli_query($this->con,$sql);

    }
}