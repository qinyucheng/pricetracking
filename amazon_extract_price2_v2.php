<?php
set_time_limit(3000);

include ('connection.php');
ini_set("session.use_cookies", 0);
ini_set("session.use_only_cookies", 0);
ini_set("session.use_trans_sid", 1);
ini_set("session.cache_limiter", "");


date_default_timezone_set("America/Chicago");
$date = date("Y-m-d H:i:s");

include_once ('simple_html_dom.php');
$filespath = trim($_POST['Path']);
print $filespath;
printHtml($filespath,$link);

function printHtml($filespath,$link) {
   $html = new simple_html_dom();
   $html->load_file($filespath);
	 
	$listIDArr = array();
    $Arr = array();
    $infoList = array();
    //get saler Name
    $data_asin = $html->find('div[id=cerberus-data-metrics]', 0);
    $landingImage = $html->find('img[id=landingImage]', 0);
    if($landingImage!='')
	{
		$imgurl = $landingImage->getAttribute('data-old-hires');
	}
   
   
    $availability = $html->find('div[id=availability]', 0);
    $availabilitySpan1 = $availability->find('span[class=a-size-medium a-color-price]', 0);
    $availabilitySpan2 = $availability->find('span[class=a-size-medium a-color-success]', 0);
	if($availabilitySpan1!='')
	{
		
		$isAvailability=  trim($availabilitySpan1->plaintext);
	}
	else if($availabilitySpan2!='')
	{
		$isAvailability= trim($availabilitySpan2->plaintext);
		
	}
	else
	{
		$isAvailability=  'no data';
	}
	
	if($data_asin!='')
	{
		 $asin = $data_asin->getAttribute('data-asin');
   
			$price = $data_asin->getAttribute('data-asin-price');
	}
	else
	{
		$asin='';
		$price='';
		
	}
   
	
	
	if(empty($price))
	{
		$price='';
	}
    //$priceSpan = trim($html->find('span[id=priceblock_ourprice]', 0)->plaintext);
    $productTitleSpan = addslashes(trim($html->find('Span[id=productTitle]', 0)->plaintext));
    $brand = trim($html->find('a[id=bylineInfo]', 0)->plaintext);
	
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
		$merchant=addslashes($merchant_find->plaintext);
		
	}
	
	
	echo  trim($asin."<br>");
	echo  trim($price."<br>");
	echo  trim($productTitleSpan."<br>");
	echo  trim($brand."<br>");
	echo  trim($merchant."<br>");
	echo  trim($isAvailability."<br>");
	echo  trim($imgurl."<br>");
	
	$html->clear();
	unset($html);
	if($asin!='')
	{
		insertToDatabase($asin,$imgurl,$productTitleSpan,$price,$brand, $merchant,$isAvailability,$link );
	}
	echo  $filespath."<br>";
	
}

function insertToDatabase($asin,$imgurl,$title,$price,$brand, $seller,$isavailable,$link )
{
	$sql = "UPDATE  `amazon_listing` SET imgurl='$imgurl', title='$title', price='$price', brand='$brand', seller='$seller',isavailable='$isavailable' WHERE asin='$asin';";
	
		if ($link->query($sql) === TRUE) {
		
			echo "UPDATE Success----------------------.<br>";
		} else {
			echo "Error----------------: " . $sql . "<br>" . $link->error;
		}
}
 
?>