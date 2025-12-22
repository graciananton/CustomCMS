<?php
    class View {
        private $aDatabaseManager;
        private $header;
        private $navBar;
        private $footer;
        public function __construct(){
            $dbInfo = Config::getMySQLInfo();
            $this->aDatabaseManager = new databaseManager("",$dbInfo["dbHost"],$dbInfo["dbPassword"],$dbInfo["dbUserName"],$dbInfo["dbName"]);
            //$this->aDatabaseManager = new databaseManager("",Config::$dbInfo["dbHost"],Config::$dbInfo["dbPassword"],Config::$dbInfo["dbUser"],Config::$dbInfo["dbName"]);

        }
        public function displayLoginInfo(){
            include_once "../templates/menu.php";
        ?>
            <h3>Password/Username Information</h3>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Password</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>Admin Login - basil_anton@yahoo.ca</td>
                    <td>Admin Login - 78Agracian</td>
                    </tr>
                </tbody>
        </table>
	
            <h3>Sunday Description</h3>Come join us this Sunday at 10 a.m. Our service takes place at 100 St. Patrick's Building in Carleton University. Click here for directions to reach our service.
                                <br/><br/>
          <h3>Wednesday Description</h3>This Bible Study occurs every Wednesday on Zoom at 7 p.m. 
Zoom Meeting ID - 657 958 3872
Book We Are Covering: 2 Thessalonians

            <br/><br/>
            <h3>Keyword for Inserting Blog At Bottom of Page</h3> #COG_INCLUDE_CONTENT_1#
            <br/><br/>
            <h3>Keyword for Inserting Web Page Views</h3> #COG_WEBANALYTICS
            <h3>How To Use Admin and Google Calendar PDF File:</h3> <a target="_blank" href="https://www.canva.com/design/DAGMhXQq1OQ/TZzjkpv27R2ImkDz81ZDFg/edit?utm_content=DAGMhXQq1OQ&utm_campaign=designshare&utm_medium=link2&utm_source=sharebutton">How To Use Admin</a>
            <?php
        }
        public function displayInsertAdminPage($keyword,$pageContent){
                $pid = "";
                $title = "";
                $tamilTitle = "";
                $pageType = "";
                $content="";
                $tamilContent = "";
                $shortTitle="";
                $buttonValue = "Submit";
                $searchKeyword = "";
                if($keyword == 'edit'){
                    $pageList= $pageContent[0];
                    $pid = $pageList->pid;
                    $title = $pageList->title;
                    $tamilTitle = $pageList->tamilTitle;
                    $shortTitle = $pageList->shortTitle;
                    $pageType = $pageList->pageType;
                    $content = $pageList->content;
                    $searchKeyword = $pageList->searchKeyword;
                    $tamilContent=$pageList->tamilContent;
                    $buttonValue ="Update";
                }
            
        ?>
                <?php
                    include_once "../templates/menu.php";
                ?>
                <div id = 'adminForms'>
                    <form enctype='multipart/form-data' action='' method='post' id='personForm'>
                        <div id = "grid-item">
                            <label for = "title">Title:</label>
                            <input type='text' id='title' name = 'title'  oninput="updateContent()" value = <?php echo $title; ?>>
                            
                        </div>
                        <div id = "grid-item">
                            <label for = "shortTitle">Short Title:*</label>
                            <input type='text' id="shortTitle" name = 'shortTitle'  value = <?php echo $shortTitle; ?>>
                        </div>
                        <div id='grid-item'>
                            <label for='tamilTitle'>Tamil Title:</label>
                            <input type='text' id='tamilTitle' name='tamilTitle' value=<?php echo $tamilTitle;?>>
                        </div>
                        <div id="grid-item">
                            <label for="pageType">Page Type:</label>
                            <select name="pageType" id="pageType" value = <?php echo $pageType;?>>
                                <?php 
                                if($pageType =='Content'){
                                    echo "<option value='Content' selected>Content</option>
                                           <option value='Config'>Config</option>
                                            ";
                                }
                                if($pageType=='Config'){
                                    echo "<option value='Content'>Content</option>
                                          <option value='Config' selected>Config</option>";
                                }
                                if($pageType ==""){
                                    echo"
                                    <option value='Content'>Content</option>
                                    <option value='Config'>Config</option>
                                    ";
                                }
                                ?>
                            </select>
                        </div>  
                        <?php
                        if($keyword == "edit"){
                        ?>
                                <div id ="grid-item">
                                    <label for="pid">Page Id:**</label>
                                    <input type ="text" name="pid"  value ='<?php echo $pid; ?>' readonly disabled/>
                                </div>
                        <?php
                            }
                        ?>
                        <?php 
                        if($pageType == "Content" || $keyword == "insert"){
                        ?>
                            <div id="grid-item">
                                <label for = "content">Content:</label><br/>
                                <textarea id="content" name="content" rows="25" cols="500"><?php echo $content;?></textarea>
                            </div>
                            <br/>
                            <div id='grid-item'>
                                <label for ="tamilContent">Tamil Content:</label><br/>
                                <textarea id='content' name='tamilContent' rows='25' cols='500'><?php echo $tamilContent;?></textarea>
                            </div>
                            <div id="grid-item">
                                <label for = "keywords">Search Keywords(separate keywords with commas)</label>
                                <textarea id='searchKeywords' name="searchKeyword" rows="25" cols="250"><?php echo $searchKeyword;?></textarea>
                            </div>
                        <?php
                           }
                            if($pageType == "Config"){
                        ?>
                            <br/>
                            <div id="grid-item">
                                <label for = "content">Content:</label><br/>
                                <textarea id="config" name="content" rows="25" cols="200"><?php echo $content;?></textarea>
                            </div>
                            <div id='grid-item'>
                                <label for ="tamilContent">Tamil Content:</label><br/>
                                <textarea id='config' name='tamilContent' rows='25' cols='500'><?php echo $tamilContent;?></textarea>
                            </div>
                            <br/>
                        <?php
                       }
                        ?>
                    
                        <input type = 'hidden' value = '<?php echo $pid;?>' name = 'pid' />
                        <input type='submit' id='submit' value='<?php echo $buttonValue;?>' name='submit'/>
                        <?php
                        
                        ?>
                        
                    </form>
                </div>
                <div>
                    *Short title is not a required form to fill<br/>
                    <?php
                    if($keyword == 'edit'){
                        echo "**Page Id is a field which cannot be altered. It is only used  your reference in placing links in the tinymc editor, topNav, or bottomNav";
                    }
                    ?>
                </div>
            <?php
        }
        public function createTableByPageViews($pageViewsSet){
            //echo "CreatingTableByPageViews()";
            include_once "../templates/menu.php";
            $this->displaySearchForm("pageViews");

            echo "<table border = '1px solid black'>";
            if(count($pageViewsSet)>0){
                echo "<tr><th>IP-Address:</th><th>Date:</th></tr>";

            }
            $size = count($pageViewsSet);
            $row ="<tr>
                       <td style ='text-align:center'>%s</td>
                       <td style ='text-align:center'>%s</td>
                   </tr>";
            for($i=0;$i<$size;$i++){
                $obj = $pageViewsSet[$i];
                if($obj){                      
                       echo sprintf($row,$obj->ip_address,$obj->date_Inserted);
                }
            }
            echo "</table>";

        }
        public function createTableBySearchResult($pageList){
            include_once "../templates/menu.php";
            //print_r($pageList);
            echo "<table border = '1px solid black'>";
            if(count($pageList)>0){
                echo "<tr><th>Title</th><th>Short Title:</th><th>Tamil Title</th><th>Page Type</th><th>Page Id</th><th>Edit</th><th>Delete</th></tr>";

            }
            $size = count($pageList);
            $row ="<tr>
                       <td style ='text-align:center'>%s</td>
                       <td style ='text-align:center'>%s</td>
                       <td style ='text-align:center'>%s</td>
                       <td style='text-align:center'>%s</td>
                       <td style='text-align:center'>%s</td>
                       <td style ='text-align:center'><a href='?req=pf-edit&pid=%s'>Edit</a></td>
                       <td style ='text-align:center'><a href='?req=pf-deleteInfo&pid=%s'>Delete</a></td>
                    </tr>";
            for($i=0;$i<$size;$i++){
                $obj = $pageList[$i];
                if($obj){                      
                       echo sprintf($row,$obj->title,$obj->shortTitle,$obj->tamilTitle,
                                   $obj->pageType,$obj->pid,$obj->pid,$obj->pid);
                }
            }
            echo "</table>";
        }
        public function displayPageInformation($pageInfo){
           // echo "<pre>";
           // print_r($pageInfo);
           // echo "</pre>";

            echo "<ul>
            <li>Title -".$pageInfo->title."</li>
            <li>Short Title -".$pageInfo->shortTitle."</li>
            <li>Tamil Title -".$pageInfo->tamilTitle."</li>
            <li>Content-".$pageInfo->content."</li>
            <li>Page Type - ".$pageInfo->pageType."</li>
            <li>Short Keywords - ".$pageInfo->searchKeyword."</li>
            <li>Page Id       - ".$pageInfo->pid."</li>
          </ul>";
          echo "<a href=\"?req=pf-delete&pid=".$pageInfo->pid."\">By clicking this link, you agree to permanently deleting this page's information</a>";
        }
        public function showWebPage($webPage){
            echo $webPage;
        }
        public function displayMediaPage($keyword,$list){
                include_once "../templates/menu.php";
            ?>
            <?php
            if($keyword =="insert"){
            ?>
                <div class="form-container">
                <h1>Video Upload Form</h1>
                <form action="../admin/index.php" enctype = 'multipart/form-data' method="post">
                    <div class="form-group">
                        <label for="uploadedDate">Upload Date:</label>
                        <input type="date" id="uploadedDate" name="uploadedDate">
                    </div>

                    <div class="form-group">
                        <label for="file">Video File:</label>
                        <input type="file" id="videoFile" name="videoFile"  required>
                    </div> 
                    <div id="grid-item">
                                <label for = "content">Notes:</label><br/>
                                <input type="text" id="input" name="notes" rows="25" cols="500"/>
                    </div>  
                    <div id="grid-item">
                                <label for = "givenBy">Given By:</label><br/>
                                <input type="text" id="givenBy" name="givenBy"/>
                    </div>  
                    <!--<div class="form-group">
                        <label for="pid">Video Page Id:</label>
                        <input type="number" id="pid" name="pid" value="" readonly disabled>
                    </div>-->
                    
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" value=""/>
                    </div>
                    <div class='form-group'>
                        <label for='category'>Category</label>
                        <input type='text' id='category' name='category' value=''/>
                    </div>
                    <button type="submit" name="submit" value="submitVideo">Upload Video</button>
                </form>
            <?php
            }
            if($keyword=="table"){
                $list =$this->aDatabaseManager->findSermonResults();
              

                echo "<table border = '1px solid black'>";
                if(count($list)>0){
                    echo "<tr><th>Video URL:</th><th>Date Uploaded:</th><th>Sermon Notes</th><th>Given By:</th><th>Title</th><th>Category</th><th>Edit</th><th>Delete</th></tr>";

                }
                $size = count($list);
                $row ="<tr>
                        <td style ='text-align:center'>%s</td>
                        <td style ='text-align:center'>%s</td>
                        <td style='text-align:center'>%s</td>
                        <td style='text-align:center'>%s</td>
                        <td style='text-align:center'>%s</td>
                        <td style='text-align:center'>%s</td>
                        <td style ='text-align:center'><a href='?req=pf-mediaEdit&pid=%s'>Edit</a></td>
                        <td style ='text-align:center'><a href='?req=pf-mediaDelete&pid=%s'>Delete</a></td>
                        </tr>";
                for($i=0;$i<$size;$i++){
                    $obj = $list[$i];                      
                        echo sprintf($row,$obj->webAddress,$obj->uploadedDate,$obj->notes,$obj->givenBy,$obj->title,$obj->category,$obj->pid,$obj->pid);
            
                }
                echo "</table>";
            }
            ?>
            <?php
            if($keyword=="edit"){
                $list = $this->aDatabaseManager->findSermonPageInformationByPid($list['pid']);
            ?>
                <div class="form-container">
                <h1>Video Edit Form</h1>
                <form action="../admin/index.php" enctype='multipart/form-data' method="post">
                    <div class="form-group">
                        <label for="uploadedDate">Upload Date:</label>
                        <input type="date" id="uploadedDate" name="uploadedDate" value='<?php echo $list->uploadedDate;?>' required>
                    </div>

                    <div class="form-group">
                        <label for="url">Video URL:</label>
                        <input type="url" id="videoAddress" name="videoAddress" placeholder="https://example.com/video" value='<?php echo $list->webAddress;?>' required>
                    </div>   
                    <div id="grid-item">
                        <label for = "content">Notes:</label><br/>
                        <input type="text" id="input" name="notes" value='<?php echo $list->notes;?>' rows="25" cols="500"/>                    
                    </div>
                    <div id="grid-item">
                        <label for = "givenBy">Given By:</label><br/>
                        <input type="text" id="givenBy" name="givenBy"  value='<?php echo $list->givenBy;?>' rows="25" cols="500"/>                    
                    </div>
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" value='<?php echo $list->title;?>'/>
                    </div>
                    <div class='form-group'>
                        <label for='category'>Category:</label>
                        <input type='text' id='category' name='category' value='<?php echo $list->category;?>'/>
                    </div>
                    <div class="form-group">
                        <label for="pid">Video Page Id:(disabled)</label>
                        <input type ="text" name="pid"  value ='<?php echo $list->pid; ?>' readonly/>
                    </div>
                    <button type="submit" name="submit" value="updateVideo">Update Video</button>
                    
                </form>
            <?php
            }
            if($keyword == "insertTamil"){
            ?>
                <div class="form-container">
                <h1>Tamil Video Upload Form</h1>
                <form action="../admin/index.php" method="post">
                    <div class="form-group">
                        <label for="uploadedDate">Upload Date:</label>
                        <input type="date" id="uploadedDate" name="uploadedDate" required>
                    </div>

                    <div class="form-group">
                        <label for="url">Video URL:</label>
                        <input type="url" id="videoAddress" name="videoAddress" placeholder="https://example.com/video" required>
                    </div> 
                    <div id="grid-item">
                                <label for = "content">Notes:</label><br/>
                                <input type="text" id="input" name="notes" rows="25" cols="500"/>
                    </div>  
                    <div id="grid-item">
                                <label for = "givenBy">Given By:</label><br/>
                                <input type="text" id="givenBy" name="givenBy"/>
                    </div>  
                    <!--<div class="form-group">
                        <label for="pid">Video Page Id:</label>
                        <input type="number" id="pid" name="pid" value="" readonly disabled>
                    </div>-->
                    
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" value=""/>
                    </div>
                    <div class='form-group'>
                        <label for='category'>Category</label>
                        <input type='text' id='category' name='category' value=''/>
                    </div>
                    <button type="submit" name="submit" value="submitTamilVideo">Upload Video</button>
                </form>

            <?php
            }
            if($keyword == "delete"){
                $list = $this->aDatabaseManager->findSermonPageInformationByPid($list['pid']);
                echo "
                <h1>Video Info:</h1>
                <ul>
                    <li>Video URL -".$list->webAddress."</li>
                    <li>Date Uploaded-".$list->uploadedDate."</li>
                    <li>Sermon Notes-".$list->notes."</li>
                    <li>Title -".$list->title."</li>
                    <li>Page Id       - ".$list->pid."</li>
                    <li>Given By      - ".$list->givenBy."</li>
                    <li>Category      - ".$list->category."</li>
                </ul>";
              echo "<a href=\"?req=delete&pid=".$list->pid."\">By clicking this link, you agree to permanently deleting this video's storage in the database.</a>"; 
            }
            ?>
        <?php
        }
        public function displaySearchForm($type){
           /* echo "<label for='year'>Year:</label>
                    <select id='year' name='year'>
                        <option value='2024'>2024</option>
                        <option value='2025'>2025</option>
                        <option value='2026'>2026</option>
                    </select>
                    <label for='month'>Month:</label>
                    <select id='month' name='month'>
                        <option value='January'>January</option>
                        <option value='February'>February</option>
                        <option value='March'>March</option>
                        <option value='Apiril'>Apiril</option>
                        <option value='May'>May</option>
                        <option value='June'>June</option>
                        <option value='July'>July</option>
                        <option value='August'>August</option>
                        <option value='September'>September</option>
                        <option value='October'>October</option>
                        <option value='November'>November</option>
                        <option value='December'>December</option>
                    </select>";
            if($type=="pageViews"){
                echo "<input type='hidden' name='req' value='pageViews'/>"
                echo "<input type='submit' value='pageViews' name='pageViews'/>";
            }
            else{
                echo "<input type='hidden' name='req' value='sermon'>";
                echo "<input type='submit' value='sermon' name='sermon'/>";

            }*/
            echo "";
        }
        public function createLoginForm(){
            ?>
            <form action="" method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
                <input type="hidden" name ="req" value="pf-logged"/>
				<input type="submit" value="Login">
			</form>
            <?php
        }
        public function viewCalendar(){
            include_once "../templates/menu.php";
            echo '
            <div class="form-container">
                <h1>Event Upload Form</h1>
                <form action="../admin/index.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="eventDate">Event Date:</label>
                        <input type="date" id="eventDate" name="eventDate" required>
                    </div>

                    <div class="form-group">
                        <label for="text">Event Title:</label>
                        <input type="text" id="eventTitle" name="eventTitle" required>
                    </div> 
                    <div id="grid-item">
                        <label for = "eventDescription">Event Description:</label><br/>
                        <textarea rows="7" cols="6" name="eventDescription" id="eventDescription"></textarea>
                    </div> 
                    <input type="hidden" name="req" value="eventDate"/> 
                    <button type="submit" name="submitEvent" value="">Insert Calendar Event</button>
                </form>
            </div>
            ';
        }
    }
?>
