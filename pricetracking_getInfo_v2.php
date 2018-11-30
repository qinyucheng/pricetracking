<?php
include ('connection.php');
/*
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
$sql .= "    searchlist.search_key, ";
$sql .= "    searchlist.tag ";
$sql .= "FROM ";
$sql .= "    `price_track` ";
$sql .= "LEFT JOIN searchlist ON searchlist.search_key = price_track.search_key  " ;
$sql .= "   ORDER by date DESC," ;
$sql .= "    searchlist.item_group," ;
$sql .= "    searchlist.search_key" ;*/
$sql= " SELECT * FROM `searchlist`" ;

$myArray = array();
$result=mysqli_query($link, $sql) or die ("die" .mysqli_error( print $sql));
while($row=mysqli_fetch_object($result))
{
	$myArray[] = $row;
	
}
echo json_encode($myArray);
?>