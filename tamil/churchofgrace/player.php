<html>
<head>
<style type="text/css">
body{

    PADDING: 0px;
    MARGIN: 0px;
    COLOR: white;
    FONT-FAMILY: 'Courier New', Courier, 'Times New Roman';
    BACKGROUND-COLOR:black;
    TEXT-DECORATION: none
}
</style>
<title>Church of grace - online sermons</title>
</head>
<body>

<?php
  include "tracker.php";
?>


               <?php if($playername =="mediaplayer"){ ?>

				   <OBJECT id="VIDEO" CLASSID="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6" type="application/x-oleobject" width="300" height="75">
				      <PARAM NAME="URL" VALUE="data/media/audio/<?php echo $fileName;?>">
				      <PARAM NAME="enabled" VALUE="True">
				      <PARAM NAME="AutoStart" VALUE="True">
				      <PARAM name="PlayCount" value="3">
				      <PARAM name="Volume" value="100">
				      <PARAM NAME="balance" VALUE="0">
				      <PARAM NAME="Rate" VALUE="1.0">
				      <PARAM NAME="Mute" VALUE="False">
				      <PARAM NAME="fullScreen" VALUE="False">
				      <PARAM name="uiMode" value="full">
				   </OBJECT>


				<?php } ?>

			 <?php if($playername =="quicktime"){ ?>
			  <object width="300" height="30">
			    <param name="movie" value="data/media/audio/<?php echo $fileName;?>">
			    </param>
			    <param name="wmode" value="transparent">
			    </param>
			    <embed src="data/media/audio/<?php echo $fileName;?>"
			    type="application/x-shockwave-flash" wmode="transparent"
			    width="300" height="30">
			    </embed>
			 <?php } ?>
</object>

</body>
</html>
