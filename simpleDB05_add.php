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
<title>SimpleDB 05 - Create Data</title>
<link href="css/style.css" type=text/css rel=stylesheet>
</head>

<body>

<p><a href="index.php"><b>Amazon SimpleDB PHP Demo</b></a></p>

<?php
// Include the SDK
require_once 'sdk.class.php';

$sdb = new AmazonSDB();
 
// Test data
$response = $sdb->batch_put_attributes($domain_name, array(
    '1' => array(
        'msgType' => 'S',
        'msgAddress' => '+27837431690',
        'msgText' => 'Test SMS message for ID no 1',
        'msgSubmitDate' => Date("Y-m-d H:i:s"),
    ),
    '2' => array(
        'msgType' => 'P',
        'msgAddress' => '+27837431690',
        'msgText' => 'Test phone message for ID no 2',
        'msgSubmitDate' => Date("Y-m-d H:i:s"),
    ),
    '3' => array(
        'msgType' => 'E',
        'msgAddress' => 'andre@key.co.za',
        'msgText' => 'Test email message for ID no 3 to andre@key.co.za',
        'msgSubmitDate' => Date("Y-m-d H:i:s"),
    ),
    '4' => array(
        'msgType' => 'P',
        'msgAddress' => 'andrebruton',
        'msgText' => 'Test push notification message for ID no 4',
        'msgSubmitDate' => Date("Y-m-d H:i:s"),
    ),
));
 
// Success?
if ($response->isOK()) {

  echo "Data successfully added to the domain <b>Domain " . $domain_name . "</b><br>";
	
} else {
  echo "Error getting information for the domain " . $domain_name . "<br>";
}

// echo "<pre>";
// print_r($response, false);
// echo "</pre>";

echo "<br><br><br>";

echo "<p><b>Cost</b></p>";
$request_id = $response->body->ResponseMetadata->RequestId;
$cost = $response->body->ResponseMetadata->BoxUsage;
$text = "Mass populated data to domain " . $domain_name;

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