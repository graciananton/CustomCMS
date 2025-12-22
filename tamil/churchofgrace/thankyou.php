<?php

include( "config.php");

include( "templates/top.php");

	print "<body  onload=\"fadeTxt()\">";
	print "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
	print "<tr>";
	print "<td>&nbsp;</td><td align=\"left\" valign=\"top\" background=img/bback.png width=750 height=400 class=pr_name>";
	print "<font class=pr_name><div style=\"text-align: right;\"><a href=\"index.php?id=friend\"><img src=img/friend.jpg border=0></a></div>";



			echo "<br><b>Your mail has been sent successfully.</b><br>";
			?>
			<FORM>
			<INPUT TYPE="button" VALUE="Back" onClick="history.go(-1)">
			</FORM>
			<?


	print  "</font><img src=img/contentwith.png border=0></td><td>&nbsp;&nbsp;</td>";
	print  "<td align=\"right\" valign=top width=132 class=pr_name>";
        		include( "add/add0.php" );
	print "</td>";
	print "</tr>";
	print "</table>";

include( "templates/bottom.php");

?>