<?php
include ('connection.php');
date_default_timezone_set("America/Chicago");
$date = date("Y-m-d H:i:s");
// $sql = "SELECT  * FROM `salesreceiptline" ;
$URL = $_POST['URL'];
$URL2 = $_POST['URL2'];
$Marketplace = $_POST['Marketplace'];
$result = mysqli_query($link, "SELECT * FROM listinginfo WHERE URL2 ='$URL2'");
        if (mysqli_num_rows($result) > 0) {
			echo "2";
		}
		else{
				$sql = "INSERT INTO listinginfo (`Customer`, `URL`, `URL2`, `Status`, `Date`)
				VALUES ('$Marketplace', '$URL','$URL2', '1','$date')";

				if ($link->query($sql) === TRUE) {
					echo "1";
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
							
			
		}



?>