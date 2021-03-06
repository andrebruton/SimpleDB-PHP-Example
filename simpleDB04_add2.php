<?php
session_start();

include "library/stdinc.php";
require_once(dirname(__FILE__).'/config/config.inc.php');

// error_reporting(0);

date_default_timezone_set('UTC');

$domain_name  = htmlentities($_POST['domain_name']);
$msg_id       = htmlentities($_POST['msg_id']);
$msg_type     = htmlentities($_POST['msg_type']);
$msg_address  = htmlentities($_POST['msg_address']);
$msg_text     = htmlentities($_POST['msg_text']);

// Connect to database
$db_server = mysql_connect(_DB_HOST_, _DB_USER_, _DB_PASS_);
if (!$db_server) die("Unable to connect to mySQL: " . mysql_error());
mysql_select_db(_DB_NAME_) or die ("Unable to select database: " . mysql_error());
?>

<!DOCTYPE HTML>
<html>
<head>
<title>SimpleDB 04 - Add Data</title>
<link href="css/style.css" type=text/css rel=stylesheet>
</head>

<body>

<p><a href="index.php"><b>Amazon SimpleDB PHP Demo</b></a></p>

<?php
// Include the SDK
require_once 'sdk.class.php';

$sdb = new AmazonSDB();

$response = $sdb->put_attributes($domain_name, $msg_id, array(
  'msgType' => $msg_type,
  'msgAddress' => $msg_address,
  'msgText' => $msg_text,
	'msgSubmitDate' => Date("Y-m-d H:i:s")
  )
);
 
// Success?
if ($response->isOK()) {

  echo "<p>The following data has been added to the domain <b>" . $domain_name . "</b></p>";
	
	echo "<p>Message ID: " . $msg_id . "<br>";
	echo "Message Type: " . $msg_type . "<br>";
	echo "Message Address: " . $msg_address . "<br>";
	echo "Message Text: " . $msg_text . "<br>";
	echo "Date: " . Date("Y-m-d H:i:s") . " UTC</p>";
	
} else {
  echo "Error adding data to the domain " . $domain_name . "<br>";
}

// echo "<pre>";
// print_r($response, false);
// echo "</pre>";

echo "<br>";

echo "<a href='simpleDB04_add.php?id=" . $domain_name . "'>Add more data...</a>";

echo "<br><br><br>";

echo "<p><b>Cost</b></p>";
$request_id = $response->body->ResponseMetadata->RequestId;
$cost = $response->body->ResponseMetadata->BoxUsage;
$text = "Add data to domain " . $domain_name;

echo "Request ID: " . $request_id . "<br>";
echo "Cost: " . $cost . "<br>";

$query = "INSERT INTO aws_costs (aws_costs_token, aws_costs_cost, aws_costs_notes ) ";
$query .= " VALUES ('" . $request_id . "', '" . $cost . "', '" . $text . "' ) ";
// echo "SQL: $query<p>";
$result = mysql_query($query);
if (!$result) die ("Database access failed: " . mysql_error());
?>

</body>
</html>
