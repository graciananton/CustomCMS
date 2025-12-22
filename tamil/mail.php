<?php
$to = "basil_anton@yahoo.ca";
$subject = "COG MAIL1";
$txt = "Hello world!";
$headers = "From: bas_anton2323@yahoo.ca" . "\r\n" .
"CC: dfasfadsfds@gracian.ca";

echo "result:".mail($to,$subject,$txt,$headers);
?> 