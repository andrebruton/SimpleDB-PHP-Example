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
<title>SimpleDB 02 - List Domains</title>
<link href="css/style.css" type=text/css rel=stylesheet>
</head>

<body>

<p><a href="index.php"><b>Amazon SimpleDB PHP Demo</b></a></p>

<?php
// Include the SDK
require_once 'sdk.class.php';

$sdb = new AmazonSDB();

// Instantiate
$sdb = new AmazonSDB();
$response = $sdb->domain_metadata($domain_name);
 
// Success?
if ($response->isOK()) {

  echo "<p><b>Domain " . $domain_name . "</b></p>";
	
  echo "No of Items: " . $response->body->DomainMetadataResult->ItemCount . "<br>";
  echo "Size: " . $response->body->DomainMetadataResult->ItemNamesSizeBytes . "<br>";
	
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
$text = "View details for domain " . $domain_name;

echo "Request ID: " . $request_id . "<br>";
echo "Cost: " . $cost . "<br>";

$query = "INSERT INTO aws_costs (aws_costs_token, aws_costs_cost, aws_costs_notes ) ";
$query .= " VALUES ('" . $request_id . "', '" . $cost . "', '" . $text . "' ) ";
// echo "SQL: $query<p>";
$result = mysql_query($query);
if (!$result) die ("Database access failed: " . mysql_error());
?>

<!--

[body] => CFSimpleXML Object
        (
            [@attributes] => Array
                (
                    [ns] => http://sdb.amazonaws.com/doc/2009-04-15/
                )

            [DomainMetadataResult] => CFSimpleXML Object
                (
                    [ItemCount] => 0
                    [ItemNamesSizeBytes] => 0
                    [AttributeNameCount] => 0
                    [AttributeNamesSizeBytes] => 0
                    [AttributeValueCount] => 0
                    [AttributeValuesSizeBytes] => 0
                    [Timestamp] => 1346577804
                )

            [ResponseMetadata] => CFSimpleXML Object
                (
                    [RequestId] => c5cf0599-9f89-f05b-6141-ef53e333ece4
                    [BoxUsage] => 0.0000071759
                )

-->

</body>
</html>
