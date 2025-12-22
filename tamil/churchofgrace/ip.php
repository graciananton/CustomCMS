<html>
<head>
<style type="text/css">
body{

    PADDING: 5px;
    MARGIN: 5px;
    COLOR: black;
    FONT-FAMILY: 'Courier New', Courier, 'Times New Roman';
    BACKGROUND-COLOR:white;
    TEXT-DECORATION: none
    font-size: 12px;
}
table.sample {
	border-width: 0px;
	border-spacing: 0px;
	border-style: none;
	border-color: gray;
	border-collapse: collapse;
	background-color: white;
	font-size: 12px;
}

table.sample td {
	border-width: 1px;
	padding: 1px;
	border-style: dotted;
	border-color: gray;
	background-color: white;
	-moz-border-radius: ;
	font-size: 11px;
	FONT-FAMILY: 'Courier New', Courier, 'Times New Roman';
}
table.sample th {
	border-width: 1px;
	padding: 1px;
	border-style: solid;
	border-color: gray;
	background-color: silver;
	-moz-border-radius: ;
	FONT-FAMILY: 'Courier New', Courier, 'Times New Roman';
	font-size: 12px;
}

</style>
<title>Church of grace</title>
</head>
<body>

<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
$jtcount=0;
$cogcount=0;
$cogmediacount=0;
$hcarescount=0;
$wctcount=0;
$gfancount=0;
 function countdomains($urlList,$dateList,$currentdate){
		   
		   global $jtcount,$cogcount,$cogmediacount,$hcarescount,$wctcount,$gfancount;
  		   $str.="";
		   //$k="<hr>";
		   
		   //$uarray = explode(",",$urlList);
		   //$darray = explode("|",$dateList);
		   //foreach ($darray as $key => $value) {
				//if(strpos($value, $currentdate)>0){
				    // $k.=$uarray[$key]."*".$value."@".$currentdate."&<br>";
					//$k.=$value."<br>";
				//}
		  // }
		   
		   $jt=substr_count($urlList, 'joshtrans.com'); 
		   if($jt>0){ $str.="jt(".$jt.") "; $jtcount+= $jt; }
		   
		   $cog=substr_count($urlList, 'ottawachurchofgrace.com'); 
		   if($cog>0){  $str.="cog(".$cog.") "; $cogcount+=$cog; }
		   
		   $cogmedia=substr_count($urlList, '.mp3'); 
		   if($cogmedia>0){  $str.="mp3(".$cogmedia.") ";$cogmediacount+= $cogmedia; }
		   
		   $he=substr_count($urlList, 'hecares'); 
		   if($he>0){  $str.="hcares(".$he.") "; $hcarescount+=$he; }
		   
		   $wct=substr_count($urlList, 'webcareteam');  
		   if($wct>0){  $str.="wct(".$wct.") "; $wctcount+=$wct; }
			 
		   $gfan=substr_count($urlList, 'gfan.info'); 
		   if($gfan>0){  $str.="gfan(".$gfan.") "; $gfancount+=$gfan; }
		   	
		 return $str;//."#".count($uarray)."#".count($darray)."#".$k."->".$currentdate."@";	   
}


$table    ="clientsinfo";
$host     ="p3smysql63.secureserver.net";
$username ="ottawachurch";
$password ="Basil1978";
$db       ="ottawachurch";


$rip 	 = $_GET['ip'];
$request = $_GET['r'];

$today = date("Y-m-d"); 
echo "<a href=ip.php>Home[ $today ] </a> <br>";
                        
$con = mysql_connect($host,$username,$password);
if ($con){
      mysql_select_db($db, $con);

      $where =(empty($rip))?" ORDER BY date DESC": " WHERE ip='".$rip."' ORDER BY date DESC";
	  $result = mysql_query("SELECT * FROM ".$table." $where");
	  echo "<table cellspacing=0 cellpadding=0 class=sample width=100%>";
	  echo "<tr><th>&nbsp;&nbsp;&nbsp;&nbsp;</th><th>&nbsp;IP</th><th width=300px>&nbsp;Domain</th><th>&nbsp;Count</th><th width=500px>&nbsp;URL</th><th  width=200px>&nbsp;Date </th><th>&nbsp;Who</th></tr>";
	  $i=1;
	  $isToday=0;
	  while($result && $row = mysql_fetch_array($result)){

	        $dates     = (array_reverse(explode("|",$row['lastvisit'])));
	        if($request!="o"){
	            $dates     = array_slice($dates, 0, 1);
            }

	        $messages  = array_reverse(explode(",",$row['page']));
	        if($request!="o"){
	        	$messages  = array_slice($messages, 0, 1);
            }
	        $last_vist = join("<br>",($dates));
	        $filenames = join("<br>",($messages));
			
			
			if(substr($row['date'], 0, 10) == $today){

						echo "<tr><td valign=top align=center><a href=ip.php?ip=".$row['ip']."&r=o>".$i."</a></td>";
						echo "<td valign=top align=left><a href=\"http://ipinfodb.com/ip_locator.php?ip=".$row['ip']."\">".$row['ip']."</a></td>";
						echo "<td valign=top align=left>".$row['domain']."&nbsp;</td>";
						
						echo "<td valign=top align=left width=20px>".$row['visitcount']."</td>";
						echo "<td valign=top align=left>".trim($filenames." - ".countdomains($row['page'],$row['lastvisit']),substr($row['date'], 0, 10))."</td>";
						echo "<td valign=top align=left>".$row['date']."</td>";//###.substr($row['date'], 0, 10).##</td>
						if($request=="o"){
						echo "<td valign=top align=left>".$last_vist."*</td>";
						}
						echo "<td valign=top align=left>".$row['who']."&nbsp;</td>";
						echo "</tr>";
						$isToday=1;
			
			}else{
			            if($isToday==1){
						   $isToday=0;
						    echo "<tr><td colspan=8>  Joshtrans(".$jtcount.")  Churchofgrace(".$cogcount.")  Media(".$cogmediacount.")  Hecares(".$hcarescount.")  Webcareteam(".$wctcount.")  GFAN(".$gfancount.") &nbsp;<br><br><br></td></tr>";
							$today=substr($row['date'], 0, 10);
						}
						echo "<tr><td valign=top align=center><a href=ip.php?ip=".$row['ip']."&r=o>".$i."</a></td>";
						echo "<td valign=top align=left><a href=\"http://ipinfodb.com/ip_locator.php?ip=".$row['ip']."\">".$row['ip']."</a></td>";
						echo "<td valign=top align=left>".$row['domain']."</td>";
						
						echo "<td valign=top align=left width=20px>".$row['visitcount']."</td>";
						echo "<td valign=top align=left>".$filenames." - ".countdomains($row['page'],$row['lastvisit'],substr($row['date'], 0, 10))."</td>";
						echo "<td valign=top align=left>".$row['date']."</td>";
						if($request=="o"){
						echo "<td valign=top align=left>".$last_vist."*</td>";
						}
						echo "<td valign=top align=left>".$row['who']."&nbsp;</td>";
						echo "</tr>";
			}
			$i=$i+1;
	  }
	  echo "</table>";
}

  mysql_close($con);


?>
</body>
</html>
