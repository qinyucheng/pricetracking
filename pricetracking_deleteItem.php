<?php
include ('connection.php');
date_default_timezone_set("America/Chicago");
$date = date("Y-m-d H:i:s");
// $sql = "SELECT  * FROM `salesreceiptline" ;
$asin = $_POST['ASIN'];


$sql = "DELETE FROM `listinginfo` where itemID='$asin';";

$sql2 = "DELETE FROM `price_track` where asin='$asin';";
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