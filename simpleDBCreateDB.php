<?php
session_start();

include "library/stdinc.php";
require_once(dirname(__FILE__).'/config/config.inc.php');

// error_reporting(0);

date_default_timezone_set('UTC');
?>

<!DOCTYPE HTML>
<html>
<head>
<title>SimpleDB - List Costs</title>
<link href="css/style.css" type=text/css rel=stylesheet>
</head>

<body>

<p><a href="index.php"><b>Amazon SimpleDB PHP Demo</b></a></p>

<p><b>Create Database</b></p>

<?php
// Connect to database
$db_server = mysql_connect(_DB_HOST_, _DB_USER_, _DB_PASS_);
if (!$db_server) die("Unable to connect to mySQL: " . mysql_error());
mysql_select_db(_DB_NAME_) or die ("Unable to select database: " . mysql_error());

// Generate table 'aws_costs'
echo "Table: aws_costs<br>";

// Delete table is it exists
if(!mysql_query("DROP TABLE IF EXISTS aws_costs"))
  die(sql_error());

$users_tablename = "aws_costs";
$users_table_def = "aws_costs_id INT(11) NOT NULL AUTO_INCREMENT, ";
$users_table_def .= "aws_costs_token VARCHAR(50) DEFAULT NULL, ";
$users_table_def .= "aws_costs_cost FLOAT NOT NULL DEFAULT '0', ";
$users_table_def .= "aws_costs_notes VARCHAR(250) DEFAULT NULL, ";
$users_table_def .= "aws_costs_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, ";
$users_table_def .= "PRIMARY KEY (aws_costs_id)";
// echo $users_table_def;

// Create table aws_costs
if(!mysql_query("CREATE TABLE $users_tablename ($users_table_def)"))
  die(mysql_error());
echo "Successfully created table $users_tablename.<br>";


// Generate table 'aws_server'
echo "Table: aws_server<br>";

// Delete table is it exists
if(!mysql_query("DROP TABLE IF EXISTS aws_server"))
  die(sql_error());

$users_tablename = "aws_server";
$users_table_def = "aws_server_id INT(11) NOT NULL AUTO_INCREMENT, ";
$users_table_def .= "aws_server_name VARCHAR(50) DEFAULT NULL, ";
$users_table_def .= "aws_server_domain VARCHAR(50) DEFAULT NULL, ";
$users_table_def .= "aws_server_code VARCHAR(20) DEFAULT NULL, ";
$users_table_def .= "aws_server_location VARCHAR(60) DEFAULT NULL, ";
$users_table_def .= "aws_server_valid CHAR(1) NOT NULL DEFAULT 'N', ";
$users_table_def .= "PRIMARY KEY (aws_server_id)";
// echo $users_table_def;

$users_table_data = "INSERT INTO aws_server (aws_server_id, aws_server_name, aws_server_domain, aws_server_code, aws_server_location, aws_server_valid) ";
$users_table_data .= " VALUES (1, 'REGION_VIRGINIA', 'sdb.amazonaws.com', 'us-east-1', 'US East (Northern Virginia) Region', 'Y'), ";
$users_table_data .= " (2, 'REGION_CALIFORNIA', 'sdb.us-west-1.amazonaws.com', 'us-west-1', 'US West (Northern California) Region', 'N'), ";
$users_table_data .= " (3, 'REGION_OREGON', 'sdb.us-west-2.amazonaws.com', 'us-west-2', 'US West (Oregon) Region', 'N'), ";
$users_table_data .= " (4, 'REGION_SAO_PAULO', 'sdb.sa-east-1.amazonaws.com', 'sa-east-1', 'South America (Sao Paulo) Region', 'N'), ";
$users_table_data .= " (5, 'REGION_IRELAND', 'sdb.eu-west-1.amazonaws.com', 'eu-west-1', 'EU (Ireland) Region', 'Y'), ";
$users_table_data .= " (6, 'REGION_SINGAPORE', 'sdb.ap-southeast-1.amazonaws.com', 'ap-southeast-1', 'Asia Pacific (Singapore) Region', 'N'), ";
$users_table_data .= " (7, 'REGION_TOKYO', 'sdb.ap-northeast-1.amazonaws.com', 'ap-northeast-1', 'Asia Pacific (Tokyo) Region', 'N') ";
// echo $users_table_data . "<p>";

// Create table aws_costs
if(!mysql_query("CREATE TABLE $users_tablename ($users_table_def)"))
  die(mysql_error());
echo "Successfully created table $users_tablename.<br>";

if(!mysql_query($users_table_data))
  die("Error adding data to $users_tablename. SQL: " . mysql_error() . "<br>SQL: $users_table_data<br>");
echo "Successfully added data to $users_tablename.<br><br>";

?>

</body>
</html>