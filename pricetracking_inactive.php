<?php
include ('connection.php');
date_default_timezone_set("America/Chicago");
$date = date("Y-m-d H:i:s");
// $sql = "SELECT  * FROM `salesreceiptline" ;
$asin = $_POST['ASIN'];


$sql = "UPDATE   `listinginfo` SET STATUS=0 WHERE itemID='$asin';";
$sql2 = "UPDATE   `price_track` SET STATUS=0 WHERE asin='$asin';";


if ($link->query($sql) === TRUE) {
		if ($link->query($sql2) === TRUE) {
			echo "1";
		}
		else {
	echo "Error: " . $sql2 . "<br>" . $link->error;
}
	
} else {
	echo "Error: " . $sql . "<br>" . $link->error;
}



?>