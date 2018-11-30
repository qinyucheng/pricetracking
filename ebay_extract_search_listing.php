<?php
include ('connection.php');
ini_set("session.use_cookies", 0);
ini_set("session.use_only_cookies", 0);
ini_set("session.use_trans_sid", 1);
ini_set("session.cache_limiter", "");
date_default_timezone_set("America/Chicago");
$date = date("Y-m-d");
session_start();

include ('connection.php');
date_default_timezone_set("America/Chicago");
$date = date("Y-m-d H:i:s"); 
include_once('simple_html_dom.php');

//$url = stripslashes(trim($_POST['URL']));
//$tag1 = stripslashes(trim($_POST['TAG1']));

//$url ='https://www.ebay.com/sch/i.html?_from=R40&_trksid=m570.l1313&_nkw=atv+tires+22x7-11+22x10-9&_sacat=0';
//$tag1='atv_tires_22x7-11_22x10-9';

//$url ='https://www.ebay.com/sch/i.html?_from=R40&_trksid=p2334524.m570.l1313.TR1.TRC0.A0.H0.Xtrailer+tire+205+75R15.TRS0&_nkw=trailer+tire+205+75R15&_sacat=0&LH_TitleDesc=0&_osacat=0&_odkw=atv+tires+22x7-11+22x10-9';
//$tag1='trailer_tire_205_75R15';

//$url ='https://www.ebay.com/sch/i.html?_from=R40&_trksid=m570.l1313&_nkw=trailer+tire+205+75R14&_sacat=0&LH_TitleDesc=0&_osacat=0&_odkw=trailer+tire+205+75R15&LH_TitleDesc=0';
//$tag1='trailer_tire_205_75R14';

//$url ='https://www.ebay.com/sch/i.html?_from=R40&_trksid=m570.l1313&_nkw=24%22+RV+stabilizer+jack&_sacat=0&LH_TitleDesc=0&_osacat=0&_odkw=trailer+tire+205+75R14&LH_TitleDesc=0';
//$tag1='24_RV_stabilizer_jack';

//$url ='https://www.ebay.com/sch/i.html?_from=R40&_trksid=m570.l1313&_nkw=5+on+4.5+trailer+brake+drum&_sacat=0&LH_TitleDesc=0&_osacat=0&_odkw=24%22+RV+stabilizer+jack&LH_TitleDesc=0';
//$tag1='5_on_45_trailer_brake_drum';

//$url ='https://www.ebay.com/sch/i.html?_from=R40&_trksid=m570.l1313&_nkw=8+on+6.5+trailer+brake+drum&_sacat=0&LH_TitleDesc=0&_osacat=0&_odkw=5+on+4.5+trailer+brake+drum&LH_TitleDesc=0';
//$tag1='8 on 6.5 trailer brake drum';

//$url ='https://www.ebay.com/sch/i.html?_from=R40&_trksid=p2334524.m570.l1313.TR3.TRC1.A0.H0.X12+x+2+trailer+brake.TRS0&_nkw=12+x+2+trailer+brake&_sacat=0&LH_TitleDesc=0&_osacat=0&_odkw=8+on+6.5+trailer+brake+drum&LH_TitleDesc=0';
//$tag1='12_x_2_trailer_brake';

//$url ='https://www.ebay.com/sch/i.html?_from=R40&_trksid=p2334524.m570.l1313.TR5.TRC0.A0.H0.X10%22+trailer+brake.TRS0&_nkw=10%22+trailer+brake&_sacat=0&LH_TitleDesc=0&_osacat=0&_odkw=12+x+2+trailer+brake&LH_TitleDesc=0';
//$tag1='10_trailer_brake';


$url =trim($_POST['URL']);
$tag1 = trim($_POST['TAG']);

$html = new simple_html_dom();
$html->load_file($url);

//get saler Name
$ListDiv = $html->find('div[id=srp-river-results]',0);
$li1 = $html->find('li[id=srp-river-results-listing1]',0);

$ui = $ListDiv->find('.srp-results',0);
$liArr = $ui->find('.s-item');
$rank=0;
foreach ($liArr as $i) {
	
	$imgTag = $i ->find('img[class=s-item__image-img]',0);
	$SPONSORED = $i ->find('div[class=s-item__title-tag]',0);
	if($SPONSORED=='')
	{
		$liID = $i ->getAttribute('id');
		$div_s_item_image = $i ->find('div[class=s-item__image]',0);
		$a = $div_s_item_image ->find('a',0);
		$href = $a->getAttribute('href');
		$matches = array();
		preg_match('~/itm/.*?/(\d+)~i', $href, $m);
		print $SPONSORED.'<br>';
		print $liID.'<br>';
		print ($m[1]).'<br>';
		print $href.'<br>';
		$itemID=$m[1];
		$url=$href;
		$url2='https://www.ebay.com/itm/'.$m[1];
		
		$tag2='';
		$tag3='';
		$rank++;
		insert($link, 'Ebay',$itemID, $url, $url2, $tag1,$tag2,$tag3,$date,$rank);
		
	}
		
}



function insert($link, $customer,$itemID, $url, $url2, $tag1,$tag2,$tag3,$date,$rank) {
	 $result = mysqli_query($link, "SELECT * FROM listinginfo WHERE itemID ='$itemID'");
        if (mysqli_num_rows($result) > 0) {
			
			echo "2";
		}
		else{
				$sql = "INSERT INTO listinginfo (Customer,`itemID`, URL, `URL2`, `tag1`, `tag2`,tag3,Status,date,rank)
				VALUES ('$customer','$itemID', '$url','$url2', '$tag1','$tag2','$tag3','1','$date','$rank')";
				if ($link->query($sql) === TRUE) {
					
					echo "1";
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
			
			
		}

}
$html->clear();



?>