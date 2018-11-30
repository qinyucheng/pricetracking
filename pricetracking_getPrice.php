<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "price_info";

$link = mysqli_connect($db_host, $db_user, $db_pass, $db_name) or die ("Could not connect to MySQL");
$tag1 = trim($_POST['TAG']);
$sql = "SELECT * FROM `price_track` where `tag1`='$tag1' and status=1 order by asin, rank,date desc";

$myArray = array();
if ($result = $link->query($sql)) {

	 while ($obj=mysqli_fetch_object($result))
    {
		$myArray[] = $obj;
    
	 
	}
	mysqli_free_result($result);
}
  
	mysqli_close($link);
	echo json_encode($myArray);
 
?>