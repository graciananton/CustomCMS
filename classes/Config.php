<?php
class Config{
static $pageList = array(
        "pid"                       =>0,
        "content"                  =>1,
        "title"                     =>2,
        "shortTitle"                =>3,
        "pageType"                  =>4
     
);
public static function getMySQLInfo(){
    if($_SERVER['SERVER_NAME']=="churchofgrace.ca" || $_SERVER['SERVER_NAME']=="gracian.ca"){
        $dbInfo = array(    
            "dbHost" => 'db5016188832.hosting-data.io',
            "dbUserName" => 'dbu246834',
            "dbPassword" => '78Ijoycian#',
            "dbName"   =>'dbs13175679'
        );
    }
    else{
        $dbInfo = array(
            "dbHost" => "localhost",
            "dbPassword" => "",
            "dbUserName" => "root",
            "dbName" => "churchofgrace"
        );
    }
    return $dbInfo;
}

static $loginInfo = array(
    "username" => "basil_anton@yahoo.ca",
    "password" => "78Agracian"
);
static $pageComponents = array(
    "template" => '388',
    "header"   => '385',
    "banner"   => "376",
    "christmasHolidays" => '454',
    "navbar"   => "377",
    "content"  => "",
    "blog"     => "1",
    "contentScript" => "387",
    "footer"   => "382",
    "contact"  => "100"
);
public static $recepient = 'info@gracian.ca';
public static $errorPage = "378";

}
?>

