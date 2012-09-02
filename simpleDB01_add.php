<?php
session_start();

include "library/stdinc.php";
require_once(dirname(__FILE__).'/config/config.inc.php');

// error_reporting(0);

date_default_timezone_set('UTC');

$domain_name  = htmlentities($_POST['domain_name']);
$region_id    = htmlentities($_POST['region_id']);

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
</head>

<body>

<p><a href="index.php"><b>Amazon SimpleDB PHP Demo</b></a></p>

<?php
// Include the SDK
require_once 'sdk.class.php';

$sdb = new AmazonSDB();

if ($region_id == 1) {
  $sdb->set_region(AmazonSDB::REGION_VIRGINIA);
} elseif ($region == 2) {
  $sdb->set_region(AmazonSDB::REGION_CALIFORNIA);
} elseif ($region == 3) {
  $sdb->set_region(AmazonSDB::REGION_OREGON);
} elseif ($region == 4) {
  $sdb->set_region(AmazonSDB::REGION_SAO_PAULO);
} elseif ($region == 5) {
  $sdb->set_region(AmazonSDB::REGION_IRELAND);
} elseif ($region == 6) {
  $sdb->set_region(AmazonSDB::REGION_SINGAPORE);
} elseif ($region == 7) {
  $sdb->set_region(AmazonSDB::REGION_TOKYO);
} else {
  $sdb->set_region(AmazonSDB::REGION_VIRGINIA);
}

// If the domain already exists there is no change
$response = $sdb->create_domain($domain_name);

// Success?
if ($response->isOK()) {
  echo "Domain <b>" . $domain_name . "</b> successfully created<br>";
} else {
  echo "Error creating the domain " . $domain_name . "<br>";
}

// echo "<pre>";
// print_r($response, false);
// echo "</pre>";

echo "<br><br><br>";

echo "<p><b>Cost</b></p>";
$request_id = $response->body->ResponseMetadata->RequestId;
$cost = $response->body->ResponseMetadata->BoxUsage;
$text = "Added domain " . $domain_name;

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
