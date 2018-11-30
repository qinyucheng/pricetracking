<?php
include ('connection.php');
$url1 = stripslashes(trim($_POST['URL1']));
$url2 = stripslashes(trim($_POST['URL2']));
$Key = stripslashes(trim($_POST['Key']));
$sql = "update searchlist set amazon_url='$url1',  ebay_url='$url2'  where search_key='$Key'";

if ($link->query($sql) === TRUE) {
	
	echo "1";
} else {
	echo "Error: " . $sql . "<br>" . $link->error;
}
?>