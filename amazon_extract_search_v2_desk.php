<?php
include ('connection_desk.php');
ini_set("session.use_cookies", 0);
ini_set("session.use_only_cookies", 0);
ini_set("session.use_trans_sid", 1);
ini_set("session.cache_limiter", "");
date_default_timezone_set("America/Chicago");
$date = date("Y-m-d");
session_start();
include_once('simple_html_dom.php');

	
$path = trim($_POST['Path']);
$filename = stripslashes(trim($_POST['FileName']));
$withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);

$search_key1= str_replace("+"," ",$withoutExt);
$search_key= str_replace("%2F","/",$search_key1);

$html = new simple_html_dom();
$html->load_file($path);
//$html->load_file('file:///C:/Users/LibraIT01/Desktop/Scrapy/AmazonIpone6Spider-master/AmazonIphone6/amazon/lawn+tire+16x6.50-8+23x10.5-12.html');

$s_result_count=$html->find('span[id=s-result-count]',0);
echo $s_result_count;

$divbtfResults=$html->find('div[id=btfResults]',0);
$divatfResults=$html->find('div[id=atfResults]',0);
if($divbtfResults!='')
{
	parseUI($link,$divbtfResults,$search_key,$date);

}
else if($divatfResults!='')
{
	
	parseUI($link,$divatfResults,$search_key,$date);
}
else{
	
	echo 'no result for '.$search_key;
}

function parseUI($link,$data,$search_key,$date)
{
		
	foreach($data->find('ul') as $ul) 
	{
		$rank=0;
		   foreach($ul->find('li') as $li) 
		   {
			   $data_asin=$li->getAttribute('data-asin');
			   $id=$li->getAttribute('id');
			   $ImgDiv=$li->find('div[class=a-fixed-left-grid-col a-col-left]',0);
			   if($ImgDiv!='')
			   {
				     $ImgTag=$ImgDiv->find('img[class=s-access-image cfMarker]',0);
					$Imgsrc=$ImgTag->getAttribute('src');
				   
			   }
			   else
			   {
					$ImgDiv2=$li->find('div[class=a-fixed-left-grid-col a-col-right]',0);
					if($ImgDiv2!='')
					{
						   $ImgTag=$ImgDiv2->find('img[class=s-access-image cfMarker]',0);
							$Imgsrc=$ImgTag->getAttribute('src');
						
					}
				  
			   }
			 
			   
			   $rightPart=$li->find('div[class=a-fixed-left-grid-col a-col-right]',0);
			   $TitleAndBy=$rightPart->find('div[class=a-row a-spacing-small]',0);
			   $a=$TitleAndBy->find('a[class=a-link-normal s-access-detail-page  s-color-twister-title-link a-text-normal]',0);
			   $title1=$a->getAttribute('title');
			   $title=addslashes($title1);
			   
			  
			   $brand1=$TitleAndBy->find('span[class=a-size-small a-color-secondary]',1)->plaintext;
			   $brand= addslashes($brand1);
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
			  str_replace("$","",$price);
				$url='https://www.amazon.com/dp/'.$data_asin;
				//echo  $id.'<br>';
				$rank++;
				/*
				echo  $data_asin.'<br>';
				echo $title.'<br>';
				echo $brand.'<br>';
				echo $price.'<br>';
				echo  $Imgsrc.'<br>';
				echo  $url.'<br>';
				echo  $rank.'<br>';
				echo  '-----------------------------<br>';
				*/
				//insert($link, $asin,$marketplace, $brand, $price, $title,$imgURL,$item_url,$seller,$sold,$item_group,$search_key,$rank,$status,);
				insert($link, $data_asin,'amazon', $brand, $price, $title,$Imgsrc,$url,$search_key,$rank,'1',$date);
				
		   }
	}
	
	
}
function insert($link, $data_asin,$marketplace, $brand, $price, $title,$Imgsrc,$url,$search_key,$rank,$status,$date) {
	
	$result=mysqli_query($link, "SELECT * FROM price_track WHERE asin ='$data_asin'  and search_key='$search_key' ") or die ("die" .mysqli_error($link));
while($row=mysqli_fetch_object($result))
	{
		//$outputArr[]=$row;
		$getStatus=$row->status;
		$getPrice=$row->price;
		
		if($getStatus==1)
		{
			if($price!= $getPrice)
			{
				$sql = "INSERT INTO price_track (asin,`marketplace`, brand, `price`, `title`, `imgURL`,item_url,search_key,date,rank,status)
				VALUES ('$data_asin','$marketplace', '$brand','$price', '$title','$Imgsrc','$url','$search_key','$date','$rank',1)";
				if ($link->query($sql) === TRUE) {
					echo $price."--price<br>";
					echo $getPrice."--getPrice<br>";
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