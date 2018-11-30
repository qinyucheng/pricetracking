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

//$url = "C:\Users\LibraIT01\Desktop\Scrapy\AmazonIpone6Spider-master\AmazonIphone6\amazon\ATV+tire+21X7-10+22X11-10.html";
//$url = "C:\Users\LibraIT01\Desktop\Scrapy\AmazonIpone6Spider-master\AmazonIphone6\amazon\ATV+tire+20X7-8+22x11-8.html";
$url = "C:\Users\LibraIT01\Desktop\Scrapy\AmazonIpone6Spider-master\AmazonIphone6\amazon\lawn+tire+13x5-6.html";
//$url = "C:\Users\LibraIT01\Desktop\Scrapy\AmazonIpone6Spider-master\AmazonIphone6\amazon\ATV+tire+21X7-10+20X10-9.html";


$html = new simple_html_dom();
$html->load_file($url);


//get saler Name
//$results_ul = trim($html->find('ul[id=s-results-list-atf]',0)->plaintext);
//$results_ul = $html->find('ul[id=s-results-list-atf]');

foreach($html->find('ul[id=s-results-list-atf]') as $ul) 
{
       foreach($ul->find('li') as $li) 
       {
            // echo  $li;
       }
}
$divbtfResults=$html->find('div[id=btfResults]',0);
foreach($divbtfResults->find('ul') as $ul) 
{
       foreach($ul->find('li') as $li) 
       {
		   $data_asin=$li->getAttribute('data-asin');
		   $id=$li->getAttribute('id');
		   $ImgDiv=$li->find('div[class=a-fixed-left-grid-col a-col-left]',0);
		   $ImgTag=$ImgDiv->find('img[class=s-access-image cfMarker]',0);
		   $Imgsrc=$ImgTag->getAttribute('src');
		   
		   $rightPart=$li->find('div[class=a-fixed-left-grid-col a-col-right]',0);
		   $TitleAndBy=$rightPart->find('div[class=a-row a-spacing-small]',0);
		   $a=$TitleAndBy->find('a[class=a-link-normal s-access-detail-page  s-color-twister-title-link a-text-normal]',0);
		   $title=$a->getAttribute('title');
		   
		  
		   $brand=$TitleAndBy->find('span[class=a-size-small a-color-secondary]',1);
		    $priceDiv=$rightPart->find('div[class=a-column a-span7]',0);
		   
		   $priceSpan=$priceDiv->find('span[class=a-offscreen]',0);
		   
		  if(empty($priceSpan))
		  {
			   $price=$priceDiv->find('span[class=a-size-base a-color-base]',0);
		  }
		  else
			  
		  {
			  $price=$priceSpan->plaintext;
			  
		  }
	   
			//echo  $id.'<br>';
			echo  $data_asin.'<br>';
			echo $title.'<br>';
			echo $brand.'<br>';
			echo $price.'<br>';
			echo  $Imgsrc.'<br>';
			echo  '-----------------------------<br>';
		 

			
       }
}


?>