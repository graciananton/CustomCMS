
<?php
class adminRequestResolver{
    private $list;
    private $model;
    private $aManager;
    public function __construct($array){
        $this->list = $array;
    }
    public function process(){
        $aView = new View();
        $req=$this->list['req'];
        //$aManager = new databaseManager("db5016188832.hosting-data.io","dbu246834","78Ijoycian#","dbs13175679");
        $aManager = new databaseManager(Config::$dbInfo["dbHost"],Config::$dbInfo["dbPassword"],Config::$dbInfo["dbUser"],Config::$dbInfo["dbName"]);
        if($req=="pf-insertCDate"){
            $aView->viewCalendar();
        }
        if($req=="sermons"){
            echo "Sermons";
        }
        if($req=="pageViews"){

        }
        if($req == "pf-logged"){ 
            include_once "../templates/menu.php";
        }
        if($req=="pf-PageViews"){
            //echo "Pf-PageViews";
            $pageViewsSet = $aManager->traverse_ip_addresses();
            /*echo "<pre>";
            print_r($pageViewsSet);
            echo "</pre>";*/
            $aView->createTableByPageViews($pageViewsSet);
        }
        if($req=="eventDate"){
            echo "Inserting Date";
            $aManager->insertEventDate($this->list);
        }
        if($req =='pf-insert')
        {
            $aView->displayInsertAdminPage("insert",$this->list); 
        }
        if($req=="pf-insertMedia"){
            $aView->displayMediaPage("insert","");
        }
        if($req=="pf-editMedia"){
            //print_r($this->list);
            $aView->displayMediaPage("table","");
        }
        if($req=="pf-mediaEdit"){
            $aView->displayMediaPage("edit",$this->list);
        }
        if($req=="pf-mediaDelete"){
            $aView->displayMediaPage("delete",$this->list);
        }
        if($this->list['submit']=="submitVideo"){
            echo "Sermon<br/>";
            $aSermon = new Sermon($this->list);
            $aSermon->processMedia();
        }
        if($this->list['submit']=="updateVideo"){

            $aSermon = new Sermon($this->list);
            $aSermon->processMedia();
        }
        if(count($this->list)==2 && $this->list['req']=="delete"){
            $aSermon = new Sermon($this->list);
            $aSermon->processMedia();
        }
        if(count($this->list)>3){
            $submitValue = $this->list['submit'];
           
            if($submitValue == 'Submit'){
                echo "Submitting";
                $aPage = new Page($this->list);
                $aManager->connect();
                echo "<pre>";
                print_r($aPage);
                echo "</pre>";
                if($aManager->insert($aPage)){     
                  echo "<br/><b>The Page Information </b>";
                }
                else{
                    echo "<br/><b>The information was not saved since the title was being repeated</b>";
                }       
            }
            if($submitValue == 'Update'){
                $aPage = new Page($this->list);
                $aManager->update($aPage);
            }
           
        }
        
        /*if($req=='pf-search'){
            $aView->displayEditAdminPage();
        }*/
        
        if($req == "pf-editConfig" || $req == "pf-editContent"){
            if($req =='pf-editContent'){
                $aManager->traverseDbByCategory('Content');
            }
            if($req =='pf-editConfig'){
                $aManager->traverseDbByCategory('Config');
            }
        }
        if($req=="pf-loginInfo"){
            $aView->displayLoginInfo();
        }
        if($req =="pf-edit"){
           $pid   = $this->list['pid'];
           $resultSet = $aManager->findMatchingRow($pid);
           $aView->displayInsertAdminPage("edit",$resultSet);

        }
        if($req == "pf-deleteInfo"){
            $pageInfo=$aManager->findPageInformation($this->list);
            $aView ->displayPageInformation($pageInfo);
        }
        if($req== "delete"){
            $aManager->deleteMedia($this->list);
        }
        if($req == "pf-delete"){
            $aManager->delete($this->list);
        }
        
        
        
    }
}
?>