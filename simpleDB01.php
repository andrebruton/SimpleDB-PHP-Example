<?php
session_start();

include "library/stdinc.php";
require_once(dirname(__FILE__).'/config/config.inc.php');

error_reporting(0);

// Connect to database
$db_server = mysql_connect(_DB_HOST_, _DB_USER_, _DB_PASS_);
if (!$db_server) die("Unable to connect to mySQL: " . mysql_error());
mysql_select_db(_DB_NAME_) or die ("Unable to select database: " . mysql_error());
?>

<!DOCTYPE HTML>
<html>
<head>
<title>SimpleDB 01 - Create Domain</title>
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

<p>Choose the region to create a database in.</p>

<p><table>
  <form action="simpleDB01_add.php" method="post" onsubmit="return Add_Form_Validator(this)" name="Add_Form">
  <tr>
    <td>Domain:</td>
  	<td><input type="text" name="domain_name" value size="30" maxlength="150"></input></td>
  </tr>
  <tr>
    <td>Region:</td>
    <td><select name="region_id" size="1">
    <?php
    // Get region info
    $query1 = "SELECT * FROM aws_server ";
    $query1 .= " WHERE aws_server_valid = 'Y' ";
    $query1 .= " ORDER BY aws_server_name ";
    // echo "Query1: $query1<br>";
    $result1 = mysql_query($query1);
    if (!$result1) die ("Database access failed: " . mysql_error());
    $rows1 = mysql_num_rows($result1);
    // echo "Rows1: $rows1<p>";

  	for ($j = 1; $j <= $rows1; ++$j)
      {
	    $row1 = mysql_fetch_row($result1);
      echo '<option value=' . $row1[0] . '>' . $row1[4] . '</option>';
	    }
    ?>
	  </select></td>
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