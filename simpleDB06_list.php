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

// Instantiate
$sdb = new AmazonSDB();

$select_expression = 'SELECT * FROM ' . $domain_name;
$next_token = null;
 
do {
  if ($next_token) {
        $response = $sdb->select($select_expression, array(
            'NextToken' => $next_token,
        ));
  } else {
    $response = $sdb->select($select_expression);
  }

  // Get Data for row 
  foreach ($response->body->SelectResult->Item as $item) 
    {
			$msgId = $item->Name;
      foreach ($item->Attribute as $attr)
        {
				  if ($attr->Name == 'msgAddress') {
					  $msgAddress = $attr->Value;
					}
				  if ($attr->Name == 'msgType') {
					  $msgType = $attr->Value;
					}
				  if ($attr->Name == 'msgSubmitDate') {
					  $msgSubmitDate = $attr->Value;
					}
				  if ($attr->Name == 'msgText') {
					  $msgText = $attr->Value;
					}
        }

      echo "<br>msgId: $msgId<br>";
      echo "msgAddress: $msgAddress<br>";
      echo "msgType: $msgType<br>";
      echo "msgSubmitDate: $msgSubmitDate<br>";
      echo "msgText: $msgText<br><br>";

    }


 
  $next_token = isset($response->body->SelectResult->NextToken)
    ? (string) $response->body->SelectResult->NextToken
    : null;
}
while ($next_token);
 
echo "<br>";
 
// Success?
if ($response->isOK()) {

  echo "Data successfully listed above for the domain <b>" . $domain_name . "</b><br>";
	
} else {
  echo "Error getting information for the domain <b>" . $domain_name . "</b><br>";
}

// echo "<pre>";
// print_r($response, false);
// echo "</pre>";

echo "<br><br><br>";

echo "<p><b>Cost</b></p>";
$request_id = $response->body->ResponseMetadata->RequestId;
$cost = $response->body->ResponseMetadata->BoxUsage;
$text = "List data for domain " . $domain_name;

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

            [SelectResult] => CFSimpleXML Object
                (
                    [Item] => Array
                        (
                            [0] => CFSimpleXML Object
                                (
                                    [Name] => 1
                                    [Attribute] => Array
                                        (
                                            [0] => CFSimpleXML Object
                                                (
                                                    [Name] => msgAddress
                                                    [Value] => +27837431690
                                                )

                                            [1] => CFSimpleXML Object
                                                (
                                                    [Name] => msgAddress
                                                    [Value] => +27731577665
                                                )

                                            [2] => CFSimpleXML Object
                                                (
                                                    [Name] => msgType
                                                    [Value] => S
                                                )

                                            [3] => CFSimpleXML Object
                                                (
                                                    [Name] => msgSubmitDate
                                                    [Value] => 2012-09-02 11:29:53
                                                )

                                            [4] => CFSimpleXML Object
                                                (
                                                    [Name] => msgSubmitDate
                                                    [Value] => 2012-09-02 11:32:49
                                                )

                                            [5] => CFSimpleXML Object
                                                (
                                                    [Name] => msgText
                                                    [Value] => Test SMS message for ID no 1
                                                )

                                            [6] => CFSimpleXML Object
                                                (
                                                    [Name] => msgText
                                                    [Value] => Test SMS duplicate for ID no 1
                                                )

                                        )

                                )

                            [1] => CFSimpleXML Object
                                (
                                    [Name] => 2
                                    [Attribute] => Array
                                        (
                                            [0] => CFSimpleXML Object
                                                (
                                                    [Name] => msgAddress
                                                    [Value] => +27837431690
                                                )

                                            [1] => CFSimpleXML Object
                                                (
                                                    [Name] => msgType
                                                    [Value] => P
                                                )

                                            [2] => CFSimpleXML Object
                                                (
                                                    [Name] => msgSubmitDate
                                                    [Value] => 2012-09-02 11:30:39
                                                )

                                            [3] => CFSimpleXML Object
                                                (
                                                    [Name] => msgText
                                                    [Value] => Test phone message for ID no 2
                                                )

                                        )

                                )

                            [2] => CFSimpleXML Object
                                (
                                    [Name] => 3
                                    [Attribute] => Array
                                        (
                                            [0] => CFSimpleXML Object
                                                (
                                                    [Name] => msgAddress
                                                    [Value] => andre@key.co.za
                                                )

                                            [1] => CFSimpleXML Object
                                                (
                                                    [Name] => msgType
                                                    [Value] => E
                                                )

                                            [2] => CFSimpleXML Object
                                                (
                                                    [Name] => msgSubmitDate
                                                    [Value] => 2012-09-02 11:31:17
                                                )

                                            [3] => CFSimpleXML Object
                                                (
                                                    [Name] => msgText
                                                    [Value] => Test email message for ID no 3
                                                )

                                        )

                                )

                            [3] => CFSimpleXML Object
                                (
                                    [Name] => 4
                                    [Attribute] => Array
                                        (
                                            [0] => CFSimpleXML Object
                                                (
                                                    [Name] => msgAddress
                                                    [Value] => andrebruton
                                                )

                                            [1] => CFSimpleXML Object
                                                (
                                                    [Name] => msgType
                                                    [Value] => P
                                                )

                                            [2] => CFSimpleXML Object
                                                (
                                                    [Name] => msgSubmitDate
                                                    [Value] => 2012-09-02 11:31:44
                                                )

                                            [3] => CFSimpleXML Object
                                                (
                                                    [Name] => msgText
                                                    [Value] => Test push notification message for ID no 4
                                                )

                                        )

                                )

                        )

                )
								
-->


</body>
</html>