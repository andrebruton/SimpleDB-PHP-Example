<?php
session_start();

include "library/stdinc.php";

// error_reporting(0);

date_default_timezone_set('UTC');

$domain_name  = htmlentities($_GET['id']);
?>

<!DOCTYPE HTML>
<html>
<head>
<title>SimpleDB 04 - Add Data</title>
<link href="css/style.css" type=text/css rel=stylesheet>
<script Language="JavaScript">
<!--
function Add_Form_Validator(theForm)
{

  if (theForm.domain_name.value == "")
  {
    alert("Please enter a value for the \"Domain\" field.");
    theForm.domain_name.focus();
    return (false);
  }

  if (theForm.domain_name.value.length < 3)
  {
    alert("Please enter at least 3 letters in the \"Domain\" field.");
    theForm.domain_name.focus();
    return (false);
  }

}
//-->
</script>
</head>

<body>

<p><a href="index.php"><b>Amazon SimpleDB PHP Demo</b></a></p>

<p>Enter the data you want to add to the domain.</p>

<p><table>
  <form action="simpleDB04_add2.php" method="post" onsubmit="return Add_Form_Validator(this)" name="Add_Form">
	<input type="hidden" name="domain_name" value="<?php echo $domain_name ?>">
  <tr>
    <td>Domain:</td>
  	<td><?php echo $domain_name ?></td>
  </tr>
  <tr>
    <td>Message ID:</td>
  	<td><input type="text" name="msg_id" value size="10" maxlength="5"></input></td>
  </tr>
  <tr>
    <td>Message Type:</td>
    <td><select name="msg_type" size="1">
		<option value='S'>SMS</option>
		<option value='P'>Phone</option>
		<option value='E'>Email</option>
		<option value='P'>Push Nitification</option>
		</select>
		</td>
  </tr>
  <tr>
    <td>Message Address:</td>
  	<td><input type="text" name="msg_address" value size="50" maxlength="250"></input></td>
  </tr>
  <tr>
    <td>Message Text:</td>
  	<td><input type="text" name="msg_text" value size="50" maxlength="155"></input></td>
  </tr>
	<tr>
	  <td colspan="2">&nbsp;</td>
	</tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="submitButtonName" value="Create"></td>
  </tr>
  </form>
</table></p>


</body>
</html>
