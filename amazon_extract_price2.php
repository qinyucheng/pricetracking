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
$url = trim($_POST['Path']);

printHtml($url);
function printHtml($filespath) {
	$html = new simple_html_dom();
   $html->load_file($filespath);
	 
	$listIDArr = array();
    $Arr = array();
    $infoList = array();
    //get saler Name
    $data_asin = $html->find('div[id=cerberus-data-metrics]', 0);
    
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
	$html->clear();
	echo  trim($asin."<br>");
	echo  trim($price."<br>");
	echo  trim($productTitleSpan."<br>");
	echo  trim($customerSpan."<br>");

}
 
?>