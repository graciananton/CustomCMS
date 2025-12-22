<?php
class Sermon{
    private $mediaList;
    private $condition;
    private $aManager;
    public function __construct($mediaList){
        $this->mediaList = $mediaList;
        $this->aManager = new databaseManager(Config::$dbInfo["dbHost"],Config::$dbInfo["dbPassword"],Config::$dbInfo["dbUser"],Config::$dbInfo["dbName"]);

    }
    public function processMedia(){
        if($this->mediaList['submit']=="submitVideo"){
            echo "Inserting...";
            $this->aManager->insertMedia($this->mediaList);
        }
        if($this->mediaList['submit']=="updateVideo"){
            echo "Update<br/>";
            $this->aManager->updateMedia($this->mediaList);
        }
        if($this->mediaList['req']=="delete"){
            echo "Deleting";
            $this->aManager->deleteMedia($this->mediaList);
        }
    }
    public function findSearchResultSet($sermonResults,$request){
        $requestYear  = $request['year'];
        $requestMonth = $request['month'];
        $resultSet = array();
        for($i=0;$i<count($sermonResults);$i++){
            $sermonObject = $sermonResults[$i];
            $uploadedDate = $sermonObject->uploadedDate;
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
            if(!empty($requestYear) && !empty($requestMonth)){
                if($requestYear == $uploadedYear && $requestMonth == $uploadedMonth){
                   // echo "Request Year == uploaded year, request month == uploaded month";
                    array_push($resultSet, $sermonObject);
                }
                else{
                }
            }

            if(!empty($requestYear) && empty($requestMonth)){
                if($requestYear == $uploadedYear){
                 //   echo "Request Year == uploaded year";
                    array_push($resultSet, $sermonObject);
                }
                else{
                }
            }
            if(!empty($requestYear) && !empty($requestMonth)){
                if($requestMonth=="--" && $requestYear == $uploadedYear){
                   // echo "Empty request Month";
                    array_push($resultSet,$sermonObject);
                }
            }

        
        }
        return $resultSet;
    }
    public function showSermonPage(){
        $sermonPage="    
கடந்த வார செய்தியைப் பாருங்கள். நீங்கள் ஒரு குறிப்பிட்ட பிரசங்கத்தைத் தேடுகிறீர்களா அல்லது எங்கள் செய்திகளின் தொகுப்பை ஆராய விரும்பினால்? ஆண்டு அல்லது மாதம் சொற்பொழிவுகளைக் கண்டறிய தேடல் அம்சத்தைப் பயன்படுத்தவும்.      <div class='form-container'>
        <form action='https://gracian.ca/churchofgrace/tamil/index.php' enctype='multipart/form-data' method='post' onsubmit = 'saveFormData'>
            <div>
                <label for='year'>ஆண்டு:</label>
                <select id='year' name='year'>
                    <option value='2021'>2021</option>
                    <option value='2022'>2022</option>
                    <option value='2024' selected>2024</option>
                </select>
            </div>

            <div>
                <label for='month'>மாதம்:</label>
                <select id='month' name='month'>
                        <option value='01'>ஜனவரி</option>
                        <option value='02'>பெப்ரவரி</option>
                        <option value='03'>மார்ச்</option>
                        <option value='04'>ஏப்ரல்</option>
                        <option value='05'>மே</option>
                        <option value='06'>ஜூன்</option>
                        <option value='07'>ஜூலை</option>
                        <option value='08'>ஆகஸ்ட்</option>
                        <option value='09'>செப்டம்பர்</option>
                        <option value='10'>அக்டோபர்</option>
                        <option value='11'>நவம்பர்</option>
                        <option value='12'>டிசம்பர்</option>
                        <option value='--' selected>--</option>
                </select>
            </div>
            <div>
                <input type='hidden' name='pid' value='420'>
               <input type='submit' value='தேடு' name='search'/>
            </div>
        </form>
        <script>
        function saveFormData(){
            let year = document.getElementById('year').value;
            let month = document.getElementById('month').value;
            localStorage.setItem('year',year)
            localStorage.setItem('month',month)

        }
        function restoreFormData() {
            const storedYear = localStorage.getItem('year');
            const storedMonth = localStorage.getItem('month');
            
            if (storedYear) {
                document.getElementById('year').value = storedYear;
            }
            if (storedMonth) {
                document.getElementById('month').value = storedMonth;
            }
        }
        window.onload = function(){
            restoreFormData();
        }
    </script>
    </div>
    ".$this->findLatestSermon();
    return $sermonPage;
    }
    public function findLatestSermon(){
        $sermonResults = $this->aManager->findSermonResults();
        //print_r($sermonResults);
        if(count($sermonResults)>0){
            $latestSermonIndex = count($sermonResults)-1;
            $latestSermonUrl = $sermonResults[$latestSermonIndex]->webAddress;
            $embedSermonUrl = $this->getYouTubeEmbedLink($latestSermonUrl);
            $latestSermon ="<h2 id='latestSermonTitle'>சென்ற வார பிரசங்கம்:</h2><iframe src=".$embedSermonUrl." height='600' width='300' id='latestSermon' allowfullscreen='allowfullscreen'></iframe>";
            return $latestSermon;
        }
        else{
            $emptyString ="";
            return $emptyString;
        }
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
    public function showSearchResult(){
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
                                <td style='padding:20px;'><a target='_blank' href=".$obj->notes.">பிரசங்க குறிப்புகள்</a></td>
                           </tr>";                 
                }
            }
        echo "</table>";
        if(count($this->mediaList)>0){
            $sermonTable = "<table>
                        <tr>
                            <th>பதிவேற்றிய தேதி</th>
                            <th>இணைய முகவரி:</th>
                            <th>தலைப்பு:</th>
                            <th>மூலம் வழங்கப்பட்டது:</th>
                            <th>பிரசங்க குறிப்புகள்:</th>
                        </tr>
                        ".$row."
                        </table>
                        <script>
                        hideLatestSermon();
                        hideLatestSermonTitle();
                        function hideLatestSermon() {
                            document.getElementById('latestSermon').style.display = 'none';
                        }
                        function hideLatestSermonTitle(){
                            document.getElementById('latestSermonTitle').style.display = 'none';
                        }
                        </script>
                        ";
        }
        else{
            $sermonTable="<div style='color:red;font-size:30px;'>முடிவுகள் எதுவும் கிடைக்கவில்லை</div><br/>
                            <script>
                        hideLatestSermon();
                        hideLatestSermonTitle();
                        function hideLatestSermon() {
                            document.getElementById('latestSermon').style.display = 'none';
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