

<script language="JavaScript" src="scriptes/gen_validatorv2.js" type="text/javascript"></script>

<form action="gdform.asp" name="myform" method="post" >

<input type="hidden" name="subject" value="Form Submission" />
<input type="hidden" name="redirect" value="thankyou.php" />

<table cellspacing="0" cellpadding="0" border="0">

	<tr> <td align="right">First Name&nbsp;:&nbsp;</td><td><input type="text" name="FirstName"></td></tr>
	<tr> <td align="right">Last Name&nbsp;:&nbsp;</td> <td><input type="text" name="LastName"></td></tr>
	<tr> <td align="right">EMail&nbsp;:&nbsp;</td> 	  <td><input type="text" name="Email"></td></tr>
	<tr> <td align="right">Phone&nbsp;:&nbsp;</td>  	  <td><input type="text" name="Phone"></td></tr>
	<tr> <td align="right" valign=top>Address&nbsp;:&nbsp;</td>
		 <td><textarea cols="20" rows="5" name="Address"></textarea></td></tr>
	<tr> <td align="right">Country&nbsp;:&nbsp;</td>
		<td>
		   <SELECT name="Country">
			<option value="" selected>[choose yours]
			<option value="008">Albania
			<option value="012">Algeria
			<option value="016">American Samoa
			<option value="020">Andorra
			<option value="024">Angola
			<option value="660">Anguilla
			<option value="010">Antarctica
			<option value="028">Antigua And Barbuda
			<option value="032">Argentina
			<option value="051">Armenia
			<option value="533">Aruba
		  </SELECT>
		</td>
	</tr>
	<tr> <td align="right"></td> <td><input type="submit" value="Submit"></td></tr>

</table>

</form>

<script language="JavaScript" type="text/javascript">

  //You should create the validator only after the definition of the HTML form
  var frmvalidator  = new Validator("myform");

  frmvalidator.addValidation("FirstName","req","Please enter your First Name");
  frmvalidator.addValidation("FirstName","maxlen=20","Max length for FirstName is 20");
  //frmvalidator.addValidation("FirstName","alpha");

  frmvalidator.addValidation("LastName","req");
  frmvalidator.addValidation("LastName","maxlen=20");

  frmvalidator.addValidation("Email","maxlen=50");
  frmvalidator.addValidation("Email","req");
  frmvalidator.addValidation("Email","email");

  frmvalidator.addValidation("Phone","maxlen=50");
  frmvalidator.addValidation("Phone","numeric");

  frmvalidator.addValidation("Address","maxlen=50");
  frmvalidator.addValidation("Country","dontselect=0");

</script>
