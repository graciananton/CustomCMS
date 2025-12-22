<?php


    $url	="http://ottawachurchofgrace.com/index.php";
    print "URL:$url";
    $content  = file_get_contents($url);
   // print "<BR>RESULT=$content#<br>";
    if ($content !== false) {
	   	   $file="index2.html";
	       $numbytes = file_put_contents($file, $content );
    	   print "URL: $url converted.<br> $numbytes bytes written\n";

    	   //echo "<br><br><hr>";
    	   //echo $content;
	} else {
	     print "error on $url";
	}

?>
