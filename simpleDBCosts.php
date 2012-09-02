<?php
session_start();

include "library/stdinc.php";
require_once(dirname(__FILE__).'/config/config.inc.php');

// error_reporting(0);

date_default_timezone_set('UTC');

$domain_name  = htmlentities($_GET['id']);

// Connect to database
$db_server = mysql_connect(_DB_HOST_, _DB_USER_, _DB_PASS_);
if (!$db_server) die("Unable to connect to mySQL: " . mysql_error());
mysql_select_db(_DB_NAME_) or die ("Unable to select database: " . mysql_error());
?>

<!DOCTYPE HTML>
<html>
<head>
<title>SimpleDB - List Costs</title>
<link href="css/style.css" type=text/css rel=stylesheet>
</head>

<body>

<p><a href="index.php"><b>Amazon SimpleDB PHP Demo</b></a></p>

<p>A summary of the costs for running the SimpleDB PHP Demo are listed below.</p>

<?php
// Check database for users info
$query = "SELECT * FROM aws_costs ";
$query .= " ORDER BY aws_costs_id DESC ";
// echo "Query: $query<br>";
$result = mysql_query($query);

if (!$result) die ("Database access failed: " . mysql_error());

$rows = mysql_num_rows($result);
// echo "Rows: $rows<p>";

echo "<table>";
echo "<tr>";
echo "<td width=200 valign=top bgcolor=" . $adHeading . " align=left><strong>Date</strong></td>";
echo "<td width=400 valign=top bgcolor=" . $adHeading . " align=left><strong>Notes</strong></td>";
echo "<td width=100 valign=top bgcolor=" . $adHeading . " align=left><strong>Cost</strong></td>";
echo "</tr>";

$cCost = 0;

for ($j = 0; $j < $rows; ++$j)
  {

    If ($j % 2) {
      $bgcolor = $adRow1;
    } Else {
      $bgcolor = $adRow2;
    }

    $row = mysql_fetch_row($result);

    echo "<tr>";
    echo "<td valign=top bgcolor=" . $bgcolor . ">$row[4]</td>";
    echo "<td valign=top bgcolor=" . $bgcolor . ">$row[3]</td>";
    echo "<td valign=top bgcolor=" . $bgcolor . ">" . number_format($row[2], 10) . "</td>";
    echo "</tr>";
	
	  $cCost = $cCost + $row[2];
	}

echo "</tr>";

echo "<tr>";
echo "<td colspan='2'><b>Total:</b></td>";
echo "<td><b>" . number_format($cCost, 10) . "</b></td>";
echo "<tr>";

echo "</table>";
?>

</body>
</html>