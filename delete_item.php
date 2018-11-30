<?php
include ('connection.php');
date_default_timezone_set("America/Chicago");
$date = date("Y-m-d H:i:s");
// $sql = "SELECT  * FROM `salesreceiptline" ;
$URL = $_POST['URL'];


$sql = "DELETE FROM `listinginfo` where URL2='$URL';";

if ($link->query($sql) === TRUE) {
	echo "1";
} else {
	echo "Error: " . $sql . "<br>" . $link->error;
}



?>