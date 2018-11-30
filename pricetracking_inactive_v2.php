<?php
include ('connection.php');
date_default_timezone_set("America/Chicago");
$date = date("Y-m-d H:i:s");
// $sql = "SELECT  * FROM `salesreceiptline" ;
$asin = $_POST['ASIN'];
$keyword = $_POST['keyword'];



$sql = "UPDATE   `price_track` SET STATUS=0 WHERE asin='$asin' and search_key='$keyword';";


if ($link->query($sql) === TRUE) {
	echo "1" ;
} else {
	echo "Error: " . $sql . "<br>" . $link->error;
}



?>