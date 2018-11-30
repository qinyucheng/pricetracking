<?php
include ('connection.php');
date_default_timezone_set("America/Chicago");
$date = date("Y-m-d H:i:s");

include_once ('simple_html_dom.php');
//$url = stripslashes(trim($_POST['URL']));
//$url ="amazon_search/atv_tires_25x8-12_25x10-12.html";
//$tag1='atv_tires_25x8-12_25x10-12';
//$url ="amazon_search/atv_tires_22x7-11_22x10-9.html";
//$tag1='atv_tires_22x7-11_22x10-9';
//$url ="amazon_search/trailer_tire_205_75R15.html";
//$tag1='trailer_tire_205_75R15';
//$url ="amazon_search/trailer_tire_205_75R14.html";
//$tag1='trailer_tire_205_75R14';
//$url ="amazon_search/24_RV_stabilizer_jack.html";
//$tag1='24_RV_stabilizer_jack';
//$url ="amazon_search/5_on_45_trailer_brake_drum.html";
//$tag1='5_on_45_trailer_brake_drum';
//$url ="amazon_search/10_trailer_brake.html";
//$tag1='10_trailer_brake';
//$url ="amazon_search/8_on_65_trailer_brake_drum.html";
//$tag1='8_on_65_trailer_brake_drum';
$url = "amazon_search/12_x_2_trailer_brake.html";
$tag1 = '12_x_2_trailer_brake.html';
$coutTop10 = 0;
try
{
    $html = new simple_html_dom();
    $html->load_file($url);

    $resultsCol = $html->find('.s-result-item');
    //$resultsCol = $html->find('li[class=s-result-item celwidget]',0);
    $rank = 0;
    foreach ($resultsCol as $li)
    {
        $asin = $li->getAttribute('data-asin');

        if (!empty($asin))
        {
            if ($coutTop10 <= 10)
            {
                $itemID = $asin;
                $url = 'https://www.amazon.com/dp/' . $asin;
                $url2 = 'https://www.amazon.com/dp/' . $asin;

                $tag2 = '';
                $tag3 = '';
                $rank++;
                $coutTop10++;
                insert($link, 'Amazon', $itemID, $url, $url2, $tag1, $tag2, $tag3, $date, $rank);

                print $coutTop10 . "<br>";
                print $rank . "<br>";
                print $asin . "<br>";
            }
            else
            {

                return;
            }

        }

    }

    $html->clear();

}
catch(Exception $e)
{
    echo 'Error download this item data';
}

function insert($link, $customer, $itemID, $url, $url2, $tag1, $tag2, $tag3, $date, $rank)
{
    $result = mysqli_query($link, "SELECT * FROM listinginfo WHERE itemID ='$itemID'");
    if (mysqli_num_rows($result) > 0)
    {

        while ($obj = mysqli_fetch_object($result))
        {
			$items = json_decode($obj, true);
			print_r($items);
			
            $getStatus = $items['Status'];
            $getTag1 =  $items['tag1'];
			print '---'.$getTag1.'<br>';
			print '---'.$getStatus.'<br>';
            if ($tag1 == $getTag1 && $getStatus == 1)
            {
                //change status
				
                
            }
            else if ($tag1 != $getTag1 && $getStatus == 0)
            {

                //change to new tag and set status=1
                $update_sql1 = "update listinginfo set tag1=$tag1, status=1  where itemID ='$itemID'";

                if ($link->query($update_sql1) === true)
                {
                    $update_sql2 = "update price_track set tag1=$tag1, status=1  where asin ='$itemID'";
                    if ($link->query($update_sql2) === true)
                    {

                        echo "update_sql success";
                    }
                    else
                    {
                        echo "Error: " . $update_sql2 . "<br>" . $link->error;
                    }

                }
                else
                {
                    echo "Error: " . $update_sql1 . "<br>" . $link->error;
                }
            }

        }

    }


	else
	{
		$sql = "INSERT INTO listinginfo (Customer,`itemID`, URL, `URL2`, `tag1`, `tag2`,tag3,Status,date,rank)
					VALUES ('$customer','$itemID', '$url','$url2', '$tag1','$tag2','$tag3','1','$date',$rank)";
		if ($link->query($sql) === true)
		{

			echo "1";
		}
		else
		{
			echo "Error: " . $sql . "<br>" . $link->error;
		}

	}

}
?>
