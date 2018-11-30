<?php
include ('connection.php');
ini_set("session.use_cookies", 0);
ini_set("session.use_only_cookies", 0);
ini_set("session.use_trans_sid", 1);
ini_set("session.cache_limiter", "");

session_start();
include ('connection.php');
date_default_timezone_set("America/Chicago");
$date = date("Y-m-d H:i:s");

include_once ('simple_html_dom.php');
$url = stripslashes(trim($_POST['URL']));
$tag1 = stripslashes(trim($_POST['TAG']));
//$url ="https://www.amazon.com/dp/B006UH5XCC";

$rank = stripslashes(trim($_POST['RANK']));

try {
    $html = new simple_html_dom();
    $html->load_file($url);
	print $html;
	/*
    $listIDArr = array();
    $Arr = array();
    $infoList = array();
    //get saler Name
    $data_asin = $html->find('div[id=cerberus-data-metrics]', 0);
    $span = $html->find('div[id=priceblock_ourprice]', 0);
	//print $data_asin;
	print $span;
    
    $asin = $data_asin->getAttribute('data-asin');
   
    $price = $data_asin->getAttribute('data-asin-price');
	if(empty($price))
	{
		$price='';
	}
    //$priceSpan = trim($html->find('span[id=priceblock_ourprice]', 0)->plaintext);
    $productTitleSpan = addslashes(trim($html->find('Span[id=productTitle]', 0)->plaintext));
    $customerSpan = trim($html->find('a[id=bylineInfo]', 0)->plaintext);
	
    $ret = $html->find('img[id=landingImage]', 0);
	$img = $ret->getAttribute('data-old-hires');
	
	
	if (empty($img))
	{
		$imgStr =htmlspecialchars_decode($ret->getAttribute('data-a-dynamic-image'));
		$imgObj=json_decode($imgStr);
		$img = key((array)$imgObj);
		
				
	}

	 
	
	$merchant_info = $html->find('div[id=merchant-info]', 0);
	$merchant_find = $merchant_info->find('a', 0);
	if(empty($merchant_find))
	{
		$merchant='';
		
	}
	else
	{
		$merchant=$merchant_find->plaintext;
		
	}
	//print $merchant;
    //insert($link, $asin, $customerSpan, $price, $productTitleSpan, $img, $url, $date,$merchant,$tag1,$rank);
	*/
}
catch(Exception $e) {
    echo 'Error download this item data';
}
function insert($link, $asin, $customerSpan, $price, $productTitleSpan, $img, $url, $date,$merchant,$tag1,$rank) {
	 $result = mysqli_query($link, "SELECT * FROM price_track WHERE asin ='$asin' and price ='$price'");
        if (mysqli_num_rows($result) > 0) {
			//echo "SELECT * FROM price_track WHERE asin ='$asin' and price ='$price' and  date='$date'";
			echo "2";
		}
		else{
				$sql = "INSERT INTO price_track (asin,`Marketplace`, Name, `price`, `title`, `imgURL`,URL,date,seller,tag1,rank)
				VALUES ('$asin','Amazon', '$customerSpan','$price', '$productTitleSpan','$img','$url','$date','$merchant','$tag1',$rank)";
				if ($link->query($sql) === TRUE) {
					
					echo "1";
				} else {
					echo "Error: " . $sql . "<br>" . $link->error;
				}
			
			
		}
			
   
}
 $html->clear();
/*
echo  trim($asin."<br>");
echo  trim($price."<br>");
echo  trim($url."<br>");
echo  trim($priceSpan."<br>");
echo  trim($productTitleSpan."<br>");
echo  trim($customerSpan."<br>");
*/
?>