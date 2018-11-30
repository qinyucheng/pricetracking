<?php
include ('connection.php');

$sql = "SELECT * FROM `listinginfo` where status=1 order by Date desc";

$myArray = array();
$result=mysqli_query($link, $sql) or die ("die" .mysqli_error());
while($row=mysqli_fetch_object($result))
{
	$myArray[] = $row;
	
}
echo json_encode($myArray);
?>