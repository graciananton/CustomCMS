
<?php
class adminRequestResolver{
    private $list;
    private $model;
    private $aManager;
    public function __construct($array){
        $this->list = $array;
    }
    public function process(){
       /* echo "Porcessing";
        echo '<br/>';
        echo 'Porcessing';*/
        $aView = new View();
        $req=$this->list['req'];
    //    echo $req;
       // echo "<br/><br/><br/>".$req."<br/><br/><br/>";
       
       // $aManager = new databaseManager("","db5016188832.hosting-data.io","dbu246834","78Ijoycian#","dbs13175679");
       $dbInfo = Config::getMySQLInfo();

      
       $aManager = new databaseManager($lang,$dbInfo["dbHost"],$dbInfo["dbPassword"],$dbInfo["dbUserName"],$dbInfo["dbName"]);
       // echo "<pre>";
       // print_r($aManager);
       // echo '</pre>';
       // echo $req."<br/><br/><br/><br/>";
        //$req = "pageViews"
        if($req=="pf-insertCDate"){
            $aView->viewCalendar();
        }
        if($req=="sermons"){
            echo "Sermons";
        }
        if($req=="pageViews"){
            ###do something
        }
        if($req=="pf-editMedia"){
            //print_r($this->list);
        
            $aView->displayMediaPage("table","");
        }
        if($req == "pf-editTamilMedia"){

            $aView->displayMediaPage("table","tamil");
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
           // echo "Inserting Date";
            $aManager->insertEventDate($this->list);
        }
        if($req =='pf-insert')
        {
            $aView->displayInsertAdminPage("insert",$this->list); 
        }
        if($req=="pf-insertMedia"){
            $aView->displayMediaPage("insert",$this->list);
        }
    
      
      
        
        if($req=="pf-mediaEdit"){
            $aView->displayMediaPage("edit",$this->list);
        }
        if($req=="pf-mediaDelete"){
            $aView->displayMediaPage("delete",$this->list);
        }
        if($this->list['submit']=="submitVideo"){
            echo "submitted Video";

            $aSermon = new Sermon($this->list,"");
            $aSermon->processMedia();
        }
        if($this->list['submit']=="submitTamilVideo"){
            $aSermon = new Sermon($this->list,"");
            $aSermon->processMedia();
        }
        if($this->list['submit']=="updateVideo"){
            $aSermon = new Sermon($this->list,"");
            $aSermon->processMedia();
        }
        if(count($this->list)==2 && $this->list['req']=="delete"){
            $aSermon = new Sermon($this->list,"");
            $aSermon->processMedia();
        }
        if(count($this->list)>3){
            $submitValue = $this->list['submit'];
            echo $submitValue."<br/>";
            if($submitValue == 'Submit'){
               /* echo "Submitting";
                echo "<pre>";
                print_r($this->list);
                echo "</pre>";*/
                $aPage = new Page($this->list,"");
                /*echo "<pre>";
                print_r($aPage);
                echo "</pre>";*/
              
                if($aManager->insert($aPage)){     
                  echo "<br/><b>The Page Information </b>";
                }
                else{
                    echo "<br/><b>The information was not saved since the title was being repeated</b>";
                }       
            }
            if($submitValue == 'Update'){
                echo "Value == Update";
                $aPage = new Page($this->list,"");
                $aManager->update($aPage);
            }
           
        }
        
        /*if($req=='pf-search'){
            $aView->displayEditAdminPage();
        }*/
        
        if($req == "pf-editConfig" || $req == "pf-editContent"){
            echo "pf-editContent1";
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
          // echo $pid;
           $resultSet = $aManager->findMatchingRow($pid);
         /*  echo "<pre>";
           print_r($resultSet);
           echo "</pre>";*/
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