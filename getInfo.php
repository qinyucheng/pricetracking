<?php
include ('connection.php');

$sql = "SELECT * FROM price_track left JOIN listinginfo on asin=listinginfo.itemID group by asin,price_track.date order by asin, price_track.Date desc";

$myArray = array();
$result=mysqli_query($link, $sql) or die ("die" .mysqli_error());
while($row=mysqli_fetch_object($result))
{
	$myArray[] = $row;
	
}
echo json_encode($myArray);
?>