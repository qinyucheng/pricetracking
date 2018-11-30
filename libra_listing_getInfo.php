<?php
include ('connection.php');

$sql = "SELECT *,IF(`seller` IS NULL or `seller` = '', 'Libra Trailer Parts', `seller`) as `seller`   FROM `amazon_listing`  where title<>''";



$myArray = array();
$result=mysqli_query($link, $sql) or die ("die" .mysqli_error( print $sql));
while($row=mysqli_fetch_object($result))
{
	$myArray[] = $row;
	
}
echo json_encode($myArray);
?>