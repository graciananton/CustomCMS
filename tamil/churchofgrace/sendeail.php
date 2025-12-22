<?php
include( "config.inc" );
include( "templates/top.php" );
?>

<table border="0" cellpadding="0" cellspacing="0" width="95%">
<tr><td align=right><br><FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1)"></FORM></td>
</tr>
<tr><td height=300 valign=top align=left>
<?php


	$visitormail= trim($_POST["visitormail"]);
	$notes 		= stripcslashes($_POST["notes"]);
	$visitor	= trim($_POST["visitor"]);
	$attn	    = trim($_POST["attn"]);

	$todayis 	= date("l, F j, Y, g:i a") ;


	$whichSite= $_SERVER["HTTP_REFERER"];
	$tarray=array();
	$tarray=split("&",$whichSite);
	$tarray=split("id=",$tarray[0]);
	$FromWhichSite=$tarray[1];


	if($FromWhichSite==""){

	 	echo "<img src=img/error.gif border=0><br>";
	 	echo "Error on submittion!<br>";
	 	echo "</td></tr></table>";
	 	include( "templates/bottom.php");
		exit();
	}
	if(!$visitormail == "" && (!strstr($visitormail,"@") || !strstr($visitormail,".")))
	{
		 echo "<img src=img/error.gif border=0> <br>Request was NOT submitted.<br><FONT COLOR=RED class=etext14>Use Back - Enter valid e-mail</FONT>\n<br><br><br>";

		 echo "</td></tr></table>";
		 include( "templates/bottom.php");
		 exit();
	}

	if(empty($visitor) || empty($visitormail) || empty($notes ))
	{
		echo "<img src=img/error.gif border=0> <br>";
		echo "Request was NOT submitted.<br><FONT COLOR=RED class=etext14>Use Back - fill in all fields</FONT>\n<br><br><br>";
		echo "</td></tr></table>";
		include( "templates/bottom.php");
		exit();
	}


	    // single recipients.
	    $to = $general_mail_address;

		// multiple recipients
		//$to  = 'aidan@example.com' . ', '; // note the comma
		//$to .= 'wez@example.com';

		// subject
		$subject = $attn." ($general_mail_subject_substring/$FromWhichSite)";


		// message
		$message  = get_header()."\n";
		$message .="  <table width=\"500\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" >\n";
		$message .="	<tr bgcolor=#F3F3F3 > <td width=\"125\" valign=top align=left> Name</td><td valign=top align=left>$visitor</td></tr>\n";
		$message .="	<tr> <td width=\"125\" valign=top align=left>                  Email</td><td valign=top align=left>$visitormail</td></tr>\n";
		$message .="	<tr bgcolor=#F3F3F3> <td width=\"125\" valign=top align=left>  Attention</td><td valign=top align=left>$attn</td></tr>\n";
		$message .="	<tr> <td width=\"125\" valign=top align=left>                  Message</td><td valign=top align=left>$notes</td></tr>\n";
		$message .="	<tr bgcolor=#F3F3F3> <td width=\"125\" valign=top align=left>Site</td><td valign=top align=left>$FromWhichSite</td></tr>\n";
		$message .="	<tr > <td width=\"125\" valign=top align=left>Date</td><td valign=top align=left>$todayis [EST]</td></tr>\n";
		$message .="  </table>\n<br><br>";
		$message .= get_extra_info()."\n";
		$message .= get_footer()."\n";

		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
		//$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
		  $headers .= "From: $visitor <$visitormail>" . "\r\n";
		//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
		//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

		// Mail it
		//mail($to, $subject, $message, $headers);

		echo "RESULT:".mail($to, $subject, $message, $headers)."#";

		if (mail($to, $subject, $message, $headers)) {
			echo("Message successfully sent!<BR>Thanks.");
		} else {
			 echo("<p><img src=img/error.gif border=0> <br><br>Message delivery failed...</p>");
		}

?>

</td></tr>
</table>

<?php require( "templates/bottom.php");?>


<?php



function get_header(){
	$str="";
	$str.="<html>";
	$str.="<head>";
	$str.="<title>Mail</title>";
	$str.="<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">";
	$str.="<style type=\"text/css\">";
	$str.="<!--";
	$str.="P {";
	$str.="	font-family: Arial, Helvetica, sans-serif;";
	$str.="	font-size: 11px;";
	$str.="	font-weight: BOLD;";
	$str.="}";
	$str.="P.text {";
	$str.="	font-family: Arial, Helvetica, sans-serif;";
	$str.="	font-size: 13px;";
	$str.="	font-weight: NORMAL;	";
	$str.="	}";
	$str.="A {";
	$str.="	font-family: Arial, Helvetica, sans-serif;";
	$str.="	font-size: 13px;";
	$str.="	font-weight: NORMAL;";
	$str.="	color: #000099;	";
	$str.="	}";
	$str.="";
	$str.="H1 {";
	$str.="	font-family: Arial, Helvetica, sans-serif;";
	$str.="	font-size: 20px;";
	$str.="	font-weight: NORMAL;	";
	$str.="	}";
	$str.="-->";
	$str.="</style>";
	$str.="</head>";
	$str.="<body>";
	$str.="<br>";
	return $str;
}

function get_footer(){
	return "</body>\n</html>";
}
function get_extra_info(){

	$str="";

	$date       = (date ("F j, Y")); ## Current date
	$time		= (date ("H:i:s")); ##  Current time
	$IPnumber	= getenv("REMOTE_ADDR"); ## IP Number assigned to your DUN
	$Browser	= $_SERVER["HTTP_USER_AGENT"]; ## Browser agent
	$ReferURL	= $_SERVER["HTTP_REFERER"]; ##  Refferal URL
	$ServerName	= $_SERVER["SERVER_NAME"]; ##
	$ServerSoftware	= $_SERVER["SERVER_SOFTWARE"]; ##

	$str.= "<table width=\"500\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" >";
	$str.="<tr BGCOLOR=\"#F3F3F3\">";
	$str.="<td width=\"125\">Visitor's ip address:</td><td >";
	$str.="<p class=\"text\"><a target=new href=\"http://$IPnumber\">$IPnumber</a></p></td>";
	$str.="</tr>";
	$str.="<tr> ";
	$str.="<td valign=top>Server name:</td><td ><p class=\"text\">$ServerName</p>";
	$str.="</td></tr>";
	$str.="<tr BGCOLOR=\"#F3F3F3\"> ";
	$str.="<td >Server:</td><td ><p class=\"text\">$ServerSoftware</p>";
	$str.="</td></tr><tr> ";
	$str.="<td >Visitor's browser:</td><td ><p class=\"text\">$Browser</p>";
	$str.="</td></tr>";
	$str.="<tr BGCOLOR=\"#F3F3F3\"><td >Page referrer:</td><td >";
	$str.="<p class=\"text\"><a href=\"$ReferURL\">$ReferURL</a></p></td></tr>";
	$str.="</table>";
    return $str;
}
?>











