<?php
include ('connection_desk.php');
ini_set("session.use_cookies", 0);
ini_set("session.use_only_cookies", 0);
ini_set("session.use_trans_sid", 1);
ini_set("session.cache_limiter", "");
date_default_timezone_set("America/Chicago");
$date = date("Y-m-d");
session_start();

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


$Path =trim($_POST['Path']);
$filename =trim($_POST['FileName']);
$withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
$search_key1= str_replace("+"," ",$withoutExt);
$search_key= str_replace("%2F","/",$search_key1);
//$tag1 = trim($_POST['TAG']);
//$url ='C:\Users\LibraIT01\Desktop\Scrapy\AmazonIpone6Spider-master\AmazonIphone6\ebay\lawn+tire+13x6.50-6.html';
//$url ='C:\Users\LibraIT01\Desktop\Scrapy\AmazonIpone6Spider-master\AmazonIphone6\ebay\ATV+tire+24x10-12.html';
//$url ='C:\Users\LibraIT01\Desktop\Scrapy\AmazonIpone6Spider-master\AmazonIphone6\ebay\ATV+tire+30X10R14.html';

$html = new simple_html_dom();
$html->load_file($Path);

//get saler Name
$mainContent = $html->find('div[id=mainContent]',0);

$ListDiv = $mainContent->find('div[id=srp-river-results]',0);
$mainContent = $html->find('div[id=mainContent]',0);
$w4= $html->find('div[id=w4]',0);
$w5= $html->find('div[id=w4]',0);
$w7= $html->find('div[id=w4]',0);

if($w4!='')
{
	$s_result_count= $w4->find('h1[class=srp-controls__count-heading]',0);
	$result_count=$s_result_count->plaintext;
}
else if($w5!='')
{
	$s_result_count= $w5->find('h1[class=srp-controls__count-heading]',0);
	$result_count=$s_result_count->plaintext;
	
}
else if($w7!='')
{
	$s_result_count= $w7->find('h1[class=srp-controls__count-heading]',0);
	$result_count=$s_result_count->plaintext;
	
}
else{
	
	$result_count='zzzzzzzzz';
}




$li1 = $html->find('li[id=srp-river-results-listing1]',0);

$ui = $html->find('ul[class=srp-results]',0);


//$ui = $ListDiv->find('.srp-results',0);
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
		$imgDiv=$i->find('div[class=s-item__image-section]',0);
		$imgDiv2=$imgDiv->find('div[class=s-item__image-wrapper]',0);
		$imgDiv3=$imgDiv2->find('img[class=s-item__image-img]',0);
		$imgSrc=$imgDiv3->getAttribute('src');
		$data_src=$imgDiv3->getAttribute('data-src');
		$title=$imgDiv3->getAttribute('alt');
		$infoDiv=$i->find('div[class=s-item__info clearfix]',0);
		$priceSpan=$infoDiv->find('span[class=s-item__price]',0);
		if($priceSpan=='')
		{
			$priceSpanPlaintext='***';
		}
		else
		{
			$priceSpanPlaintext=$priceSpan->plaintext;
		}
		
		
		$price=str_replace("$","","$priceSpanPlaintext");
		$soldSpan2=$infoDiv->find('span[class=s-item__hotness s-item__itemHotness]',0);
		$soldNum='';
		//print $price.'<br>';
		if($soldSpan2!='')
		{
			$sold2=$soldSpan2->find('span[class=clipped]',0);
			if($sold2!='')
			{
				$soldNum=$sold2->plaintext;
				
			}
			else
			{
				
				$soldNum='';
			}
			
			
		}
		$soldNum2=str_replace("Sold","","$soldNum");
		//print $sold2.'<br>';
		
		if($data_src=='')
		{
			
			
			$img=$imgSrc;
			
		}
		else
		{	$img=$data_src;
			
		}
		
		$matches = array();
		preg_match('~/itm/.*?/(\d+)~i', $href, $m);
	
		
		$itemID=$m[1];
		$url=$href;
		$url2='https://www.ebay.com/itm/'.$m[1];
		//print $liID.'<br>';
		//print $itemID.'<br>';
		//print $img.'<br>';
		//print $url2.'<br>';
		//print $sold2.'<br>';
	
		//print $title.'<br>';
		//print '------------------<br>';
		
		$rank++;
		//insert($link, $asin,$marketplace, $brand, $price, $title,$imgURL,$item_url,$seller,$sold,$item_group,$search_key,$rank,$status,);
		insert($link, $itemID,'ebay', $price, $title,$img,$url2,$search_key,$rank,'1',$date,$soldNum2);
	
		
	}
		
}

function insert($link, $itemID,$marketplace, $price, $title,$img,$url2,$search_key,$rank,$status,$date,$sold2) {
	
	$result=mysqli_query($link, "SELECT * FROM price_track WHERE asin ='$itemID'  and search_key='$search_key' ") or die ("die" .mysqli_error($link));

	while($row=mysqli_fetch_object($result))
	{
		//$outputArr[]=$row;
		$getStatus=$row->status;
		$getSold=$row->sold;
		$getPrice=$row->price;
		if($getStatus==1)
		{
			if($getSold!=$sold2 || $price!= $getPrice)
			{
				$sql = "INSERT INTO price_track (asin,`marketplace`, `price`, `title`, `imgURL`,item_url,search_key,date,rank,status,sold)
				VALUES ('$itemID','$marketplace','$price', '$title','$img','$url2','$search_key','$date','$rank',1,'$sold2')";
				if ($link->query($sql) === TRUE) {
					
					echo $getSold."--getSold<br>";
					echo $sold2."--sold2<br>";
					echo $price."--price<br>";
					echo $getPrice."--getPrice<br>";
					echo $itemID."<br>";
					
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