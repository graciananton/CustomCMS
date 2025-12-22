<?php
class webAnalytics{
    private $aDatabaseManager;
    public function __construct($request){
        $dbInfo = Config::getMySQLInfo();
        $this->aDatabaseManager = new databaseManager($request,$dbInfo["dbHost"],$dbInfo["dbPassword"],$dbInfo["dbUserName"],$dbInfo["dbName"]);
       // $this->aDatabaseManager = new databaseManager($request,Config::$dbInfo["dbHost"],Config::$dbInfo["dbPassword"],Config::$dbInfo["dbUser"],Config::$dbInfo["dbName"]);
    }
    public function viewWebAnalytics(){
       // echo "Viewing Web Analytics";
        $ipAddressSize = $this->generateWebAnalytics();
        $interval =$this->generateTimeInterval();

       // echo $ipAddressSize;
       //$timeInterval = $this->generateTimeInterval();
        if($ipAddressSize >1){
            $ipAddressStatement = "<br/>This site has been viewed ".$ipAddressSize." ".$interval;
        }
        else{
            $ipAddressStatement = "<br/>This site has been viewed ".$ipAddressSize." ".$interval;
        }
        return $ipAddressStatement;
    }
    public function generateWebAnalytics(){
       // echo "Generating WebAnalytics";
        $ipAddresses = $this->aDatabaseManager->traverse_ip_addresses();

        $ipAddressSize = count($ipAddresses);
        return $ipAddressSize;
    }
    public function generateTimeInterval(){
        $startDate = "2024-08-27";
        $startDateObject = new DateTime($startDate);
        $endDateObject = new DateTime();
        $interval = $endDateObject->diff($startDateObject);
        $dayInterval = $interval->d;
        $monthInterval = $interval->m;
        $yearInterval = $interval->y;
        if($dayInterval !="0" && $monthInterval !="0" && $yearInterval != "0"){
            $fullInterval = "times in the past ".$yearInterval." year(s), ".$monthInterval." months ".$dayInterval."days";
            return $fullInterval;
        }
        if($dayInterval !="0" && $monthInterval !="0" && $yearInterval == "0"){
            $fullInterval ="times in the past ".$monthInterval." months, and ".$dayInterval." days";
        }
        if($day !="0" && $monthInterval == "0" && $yearInterval == "0"){
            $fullInterval ="times in the past ".$dayInterval." days";
        }
        /*if($day =="0" && $monthInterval == "0" && $yearInterval == "0"){
            $fullInterval "times in the past 0 days";
        }*/
        return $fullInterval;
    }   
}