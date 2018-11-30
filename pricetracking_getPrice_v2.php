<?php
include ('connection.php');
$item_group = trim($_POST['item_group']);
$search_key = trim($_POST['search_key']);
$sql = "";
$sql .= "SELECT ";
$sql .= "    price_track.id, ";
$sql .= "    ASIN, ";
$sql .= "    marketplace, ";
$sql .= "    brand, ";
$sql .= "    price, ";
$sql .= "    title, ";
$sql .= "    imgURL, ";
$sql .= "    item_url, ";
$sql .= "    seller, ";
$sql .= "    sold, ";
$sql .= "    rank, ";
$sql .= "    DATE, ";
$sql .= "    searchlist.item_group, ";
$sql .= "    price_track.search_key, ";
$sql .= "    searchlist.search_key, ";
$sql .= "    searchlist.tag ";
$sql .= "FROM ";
$sql .= "    `price_track` ";
$sql .= "LEFT JOIN searchlist ON searchlist.search_key = price_track.search_key ";
$sql .= "where searchlist.`item_group`='$item_group'	and searchlist.`search_key`='$search_key'  and `status`=1 and `rank`<20  ";
$sql .= "ORDER BY ";
$sql .= "   ";
$sql .= "    searchlist.item_group, ";
$sql .= "    searchlist.search_key, ";
$sql .= "    price_track.ASIN, ";
$sql .= "      DATE DESC" ;


$myArray = array();
$result=mysqli_query($link, $sql) or die ("die" .mysqli_error( print $sql));
while($row=mysqli_fetch_object($result))
{
	$myArray[] = $row;
	
}
echo json_encode($myArray);
?>