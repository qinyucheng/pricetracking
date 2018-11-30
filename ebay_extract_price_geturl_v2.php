<?php
include ('connection_desk.php');

//$sql = "SELECT DISTINCT `item_url`,`asin` FROM `price_track` WHERE `marketplace`='ebay' and `rank`<50 and `status`=1 and (`seller`<>'' or `sold`<>'')";
//$sql = "SELECT DISTINCT`item_url`,asin FROM `price_track` WHERE `seller`= '' and `marketplace`='ebay' and `status`=1";
$sql = "SELECT DISTINCT`item_url`,asin FROM `price_track` WHERE `rank`<20 and `marketplace`='ebay' and `status`=1";
//echo $sql;
$myArray = array();
$result=mysqli_query($link, $sql) or die ("die" .mysqli_error());
while($row=mysqli_fetch_object($result))
{
	$myArray[] = $row;
	
}
echo json_encode($myArray);
?>