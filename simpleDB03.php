<?php
session_start();

// error_reporting(0);
?>

<!DOCTYPE HTML>
<html>
<head>
<title>SimpleDB 02 - List Domains</title>
<link href="css/style.css" type=text/css rel=stylesheet>
</head>

<body>

<p><a href="index.php"><b>Amazon SimpleDB PHP Demo</b></a></p>

<p>Select the domain you want to delete from the list below.</p>

<?php
// Include the SDK
require_once 'sdk.class.php';

// Include the SDK
$sdb = new AmazonSDB();

// Get list of domains
$domains = $sdb->get_domain_list();

foreach ($domains as $domain)
{
  echo "<a href='simpleDB03_delete.php?id=$domain'>" . $domain . "</a><br>";
}

?>

</body>
</html>