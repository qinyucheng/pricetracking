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
	
   //echo $asin.'</br>';
  // echo $new_asin.'</br>';
  // echo $priceSpan.'</br>';
   //echo $customerSpan.'</br>';
   //echo $sold.'</br>';
	
    insert($link, $asin, $priceSpan,$sold,$new_asin,$date);
}
catch(Exception $e) {
    echo 'Error download this item data';
}
function insert($link, $itemID, $price,$sold2,$eBay_new_item_number,$date) {
	
	$result=mysqli_query($link, "SELECT * from price_track where `asin`='$itemID' and `status`=1 and marketplace='ebay' GROUP by `search_key` ") or die ("die" .mysqli_error($link));

	while($row=mysqli_fetch_object($result))
	{
		//$outputArr[]=$row;
		$getStatus=$row->status;
		$getSold=$row->sold;
		$getPrice=$row->price;
		$title=$row->title;
		$imgURL=$row->imgURL;
		$item_url=$row->item_url;
		$search_key=$row->search_key;
		$rank=$row->rank;
		$seller=$row->seller;
		
		if($getStatus==1)
		{
			if(trim($getSold)!=trim($sold2) || trim($price)!= trim($getPrice))
			{
				$sql = "INSERT INTO price_track (asin,`marketplace`, `price`, `title`, `imgURL`,item_url,search_key,date,rank,status,sold,eBay_new_item_number,seller)
				VALUES ('$itemID','ebay','$price', '$title','$imgURL','$item_url','$search_key','$date','$rank',1,'$sold2','$eBay_new_item_number','$seller')";
				if ($link->query($sql) === TRUE) {
					
					echo $getSold."--getSold<br>";
					echo $sold2."--sold2<br>";
					echo $price."--price<br>";
					echo $getPrice."--getPrice<br>";
					echo $itemID."<br>";
					echo $search_key."<br>";
					
					echo "insert Success.<br>";
				} else {
					echo "Error: " . $sql . "<br>" . $link->error;
				}
				
				
			}
			else
			{
				
				echo 'no any change.<br>';
			}
			
		}
		else
		{
			echo 'this item has inactive.<br>';
			
		}
		
	}

}

$html->clear();

?>