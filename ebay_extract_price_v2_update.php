<?php
include ('connection_desk.php');
ini_set("session.use_cookies", 0);
ini_set("session.use_only_cookies", 0);
ini_set("session.use_trans_sid", 1);
ini_set("session.cache_limiter", "");
date_default_timezone_set("America/Chicago");
$date = date("Y-m-d H:i:s");
session_start();
include_once ('simple_html_dom.php');
$url =trim($_POST['url']);
$asin = stripslashes(trim($_POST['asin']));
//$rank = stripslashes(trim($_POST['RANK']));
//$tag1 = stripslashes(trim($_POST['TAG']));
//$url = "https://www.ebay.com/itm/7-50-16-750-16-7-50x16-750x16-Trailer-Tire-replace-225-90-16-K391-Bias-10pr-T-L/273019485461?_trkparms=aid%3D111001%26algo%3DREC.SEED%26ao%3D1%26asc%3D20160908105057%26meid%3D5df8af65d44946d4a2543df440ab9ea2%26pid%3D100675%26rk%3D4%26rkt%3D10%26sd%3D132374563015%26itm%3D273019485461&_trksid=p2481888.c100675.m4236&_trkparms=pageci%3Af50a8968-dc76-11e8-9d0f-74dbd180ef54%7Cparentrq%3Ac65f10b71660ac1fde5af845fffbe9b7%7Ciid%3A1";
//$url = "https://www.ebay.com/itm/264020727050";
try {
    $html = new simple_html_dom();
    $html->load_file($url);
    //get saler Name
    $new_asin = $html->find('div[id=descItemNumber]', 0)->innertext;
    $itemTitle = $html->find('h1[id=itemTitle]', 0)->innertext;
    $productTitleSpan = str_replace("<span class=\"g-hdn\">Details about  &nbsp;</span>", "", $itemTitle);
    $priceSpan1 = $html->find('span[id=prcIsum]', 0);
	
	if($priceSpan1=='')
	{
		 $priceSpan2 = $html->find('span[id=mm-saleDscPrc]', 0);
		 if($priceSpan2=='')
		{
			
			$priceSpan='';
		}
		else
		{
			$priceSpan2a = $priceSpan2->plaintext;
			$priceSpan =str_replace("US $","",$priceSpan2a);
			
		}
	}
	else
	{
		 $priceSpan = $priceSpan1->getAttribute('content');
	}
   
    $ret = $html->find('img[id=icImg]', 0);
    $img = $ret->getAttribute('src');
    $customerSpan = trim($html->find('Span[class=mbg-nw]', 0)->plaintext);
	$soldTag1=$html->find('Span[class=vi-qtyS-hot-red]', 0);

	
	if($soldTag1=='')
	{
		$soldTag2=$html->find('Span[class=vi-qtyS]', 0);
		if($soldTag2=='')
		{
			//print 'no sold tag';
			$sold=-1;
		}
		else
		{
			$soldTag2a=$soldTag2->find('a', 0);
			$sold=$soldTag2a->plaintext;
			$sold=str_replace("sold","",$sold);
			//print $sold;
		}
	
	}
	else
	{
			$soldTag1a=$soldTag1->find('a', 0);
			$sold=$soldTag1a->plaintext;
			$sold=str_replace("sold","",$sold);
			
	}
	
   echo $asin.'</br>';
   echo $new_asin.'</br>';
   echo $priceSpan.'</br>';
   echo $customerSpan.'</br>';
   echo $sold.'</br>';
	
    update($link, $asin, $customerSpan,$sold,$new_asin);
}
catch(Exception $e) {
    echo 'Error download this item data';
}
function update($link, $asin, $customerSpan, $sold,$new_asin) {
	$sql="UPDATE price_track SET seller='$customerSpan', sold=IF(sold='', '$sold', sold),eBay_new_item_number='$new_asin' WHERE asin='$asin'";
	//echo $sql.'new</br>';
   if ($link->query($sql) === TRUE) {
		echo "1";
   
	} else {
		echo "Error: " . $sql . "<br>" . $link->error;
	}
}
$html->clear();

?>