<?php
error_reporting(E_ALL);

include( "config.php");
include( "tracker.php");

if(  $root=="") {  $root="http://ottawachurchofgrace.com";}
$addid="";

$target_file="$root/data/home.html" ;
$addid      =$_GET["td"];

$id      =$_GET["id"];
$vid     =$_GET["vid"];
$view     =$_GET["view"];



if(isset($id )){
  $target_file ="$root/data/".$id .".html";
}

include( $root."/include/right_mouse_click.html" );

include( $root."/templates/top.php" );

if($addid!="no")
{   print "<body  onload=\"fadeTxt()\">";
 // print "<body  >";
	print "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
	print "<tr>";
	print "<td>&nbsp;</td><td align=\"left\" valign=\"top\" background=img/bback.png width=750 height=400 class=pr_name>";
	print "<font class=pr_name>";

					if($id=="randomlinks")
					{
					?>
					    <br><br>
					    <img src=img/lifechangeingtestimoney.png border=0>
						<iframe ALIGN=LEFT border=0 height=650 FRAMEBORDER="0" width=500 MARGINHEIGHT=0 MARGINWIDTH=0 SCROLLING=no NORESIZE scrolling=no src="COMMON/links/links.php?id=randomlinks&view=<? echo $view; ?>&vid=<? echo $vid;?>"> </iframe>
					<?
					}else{
						include( $target_file);
					}

	print  "</font><img src=img/contentwith.png border=0></td><td>&nbsp;&nbsp;</td>";
	print  "<td align=\"right\" valign=top width=132 class=pr_name>";
        		include( "add/add0.php" );
	print "</td>";
	print "</tr>";
	print "</table>";
}else{
	include( $target_file);
}


include( "$root/templates/bottom.php");

?>





