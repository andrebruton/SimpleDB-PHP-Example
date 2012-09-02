<?php
session_start();

// error_reporting(0);
?>

<!DOCTYPE HTML>
<html>
<head>
<title>SimpleDB 06 - List Data</title>
<link href="css/style.css" type=text/css rel=stylesheet>
</head>

<body>

<p><a href="index.php"><b>Amazon SimpleDB PHP Demo</b></a></p>

<p>Your domains are listed below. Select a domain to view its data.</p>

<?php
// Include the SDK
require_once 'sdk.class.php';

// Include the SDK
$sdb = new AmazonSDB();

// Get list of domains
$domains = $sdb->get_domain_list();

// echo "<pre>";
// print_r($domains, false);
// echo "</pre>";

foreach ($domains as $domain)
{
  echo "<a href='simpleDB06_list.php?id=$domain'>" . $domain . "</a><br>";
}
?>

</body>
</html>