<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "price_info";

$link = mysqli_connect($db_host, $db_user, $db_pass, $db_name) or die ("Could not connect to MySQL");

$sql = "SELECT DISTINCT(`tag1`) FROM `price_track`  ORDER by tag1 REGEXP '^[a-z]' DESC, tag1";
$myArray = array();
if ($result = $link->query($sql)) {

   /* while($row = $result->fetch_array()) {
            $myArray[] = $row;
    }*/
	 while ($obj=mysqli_fetch_object($result))
    {
		$myArray[] = $obj;
    
	 
	}
	mysqli_free_result($result);
}
  
	mysqli_close($link);
	echo json_encode($myArray);
 
?>