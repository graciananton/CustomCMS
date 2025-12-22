<?php
$fileName		=($_GET["file"]);
$playername		=($_GET["playername"]);

$ip              =  $_SERVER['REMOTE_ADDR'];
$domain   		 =  gethostbyaddr($ip);
$date       	 =  date("Y-m-d h:iA",time(date("Y-m-d h:iA"))+3*(60*60));
$area			 = "";
if($fileName!="" || $playername!=""){
	$page  =  $fileName;
}else{
	$page  = $_SERVER['SERVER_NAME'].$_SERVER["PHP_SELF"]."?".$_SERVER["QUERY_STRING"];
}
if($playername=="") $playername="mediaplayer";

$table     ="clientsinfo";
$host      ="p3smysql63.secureserver.net";
$username  ="ottawachurch";
$password  ="Basil1978";
$db        ="ottawachurch";

$con = mysql_connect($host,$username,$password);
if ($con){

  mysql_select_db($db, $con);
  if($ip!=""){
	  $result = mysql_query("SELECT ip ,lastvisit,visitcount,page FROM ".$table." WHERE ip=\"".$ip."\";");
	  if($result && $row = mysql_fetch_array($result)){
			$lastvisit = $row['lastvisit']."|".$date;
			$page      = $row['page'].",".$page;
			$count     = $row['visitcount']+1;
			$query     = "UPDATE ".$table." SET lastvisit = '".$lastvisit."',visitcount = '".$count."', page ='".$page."', date ='".$date."' WHERE ip = '".$ip."'";
			mysql_query($query);
	  }else{
	  		$lastvisit = $date;
	  		$count     = 1;
	  		mysql_query("INSERT INTO ".$table." (ip, domain, page,visitcount,lastvisit,date) VALUES ('".$ip."', '".$domain."', '".$page."','".$count."','".$lastvisit."','".$date."')");
	  }
  }
  mysql_close($con);
}

?>