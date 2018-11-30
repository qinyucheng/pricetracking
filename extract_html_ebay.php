
<?php
session_start();
$itemID = $_GET['action'];
$itemurl='https://www.ebay.com/itm/'.$itemID;

include('connection.php');
include_once ('../simple_html_dom.php');

$html = new simple_html_dom();
$html->load_file($itemurl);
$mainImg = $html->find('div[id=icImg]', 0);
$iframe = $html->find('iframe[id=desc_ifr]', 0);
$iframesrc = $iframe->getAttribute('src');
$itemTitle = $html->find('h1[id=itemTitle]', 0)->innertext;
$prcIsum = $html->find('span[id=prcIsum]', 0)->innertext;
$icImg = $html->find('img[id=icImg]', 0);
$src = $icImg->getAttribute('src');
$tableDiv = $html->find('div[id=viTabs_0_is]', 0);

// get table value

$table = $tableDiv->find('table', 0);
$rowData = array();
$outputArr = array();
$IframeoutputArr = array();

foreach($table->find('tr') as $row)
	{

	// initialize array to store the cell data from each row

	$flight = array();
	foreach($row->find('td') as $cell)
		{

		// push the cell's text to the array

		$flight[] = $cell->plaintext;
		}

	$rowData[] = $flight;
	}
	
$MainTableArr=array();

$keyarr=array();
$valuearr=array();
foreach($rowData as $row => $tr)
	{
		$count=0;
		
		$ItemSpecificsObjArr=array();
			foreach($tr as $td)
			{
					if ($count % 2 == 0)
					{
						$newtd = preg_replace("/[\n\r\t]/","",$td); 
						array_push($keyarr,trim($newtd));
						
					}
					else
					{
						
						array_push($valuearr,trim($td));
					}
				
				$count++;
				
			}
			$MainTableArr=array_combine($keyarr,$valuearr);
			
	}
	//print_r($MainTableArr);

$getIframeData=praseIframe($iframesrc);
function praseIframe($src)
	{
	$iframeHtml = new simple_html_dom();
	$iframeHtml->load_file($src);
	$CentralArea = $iframeHtml->find('div[id=CentralArea]', 0);
	$tittleArr = $CentralArea->find('.tittle', 0)->innertext;
	$specificsArr = $CentralArea->find('.specifics', 0);
	$ulliArr = $specificsArr->find('ul li');
	$newIframeuili=array();
	foreach($ulliArr as $out )
		{
			
			
			array_push($newIframeuili,$out->plaintext);
		}
	
	$content1 = $CentralArea->find('div[id=content1]', 0);
	$a = $content1->find('a', 0);
	$content1Img = $content1->find('a, img');
	$imgsrc = $content1Img[0]->getAttribute('src');
	$table = $CentralArea->find('.table', 0);
	$rowData = array();
	foreach($table->find('tr') as $row)
		{

		// initialize array to store the cell data from each row

		$flight = array();
		foreach($row->find('td') as $cell)
			{

			// push the cell's text to the array

			$flight[] = $cell->plaintext;
			}

		$rowData[] = $flight;
		}
		
		
	$count=0;
	$keyArr=array();
	$objArr=array();
	foreach($rowData as $row => $tr)
		{
			
			$valueArr=array();
			$keyValue=array();
			
			
			foreach($tr as $td)
			
			{
				if($count==0)
				{
					
					$newtd = preg_replace("/[\n\r\t]/","",$td); 
					
					array_push($keyArr,$newtd);
					
					
				}
				else{
					$newtd = preg_replace("/[\n\r\t]/","",$td); 
					array_push($valueArr,$newtd);

				}
			
			}
			
			if($count>0)
			{
				
				$keyValue=array_combine($keyArr,$valueArr);
				
				array_push($objArr,$keyValue);
			}
			
			$count++;
		}
		//print_r($objArr);
		$IframeoutputArr['iframeTable'] = json_encode($objArr);
		$IframeoutputArr['iframetittle'] = $tittleArr;
		$IframeoutputArr['iframeimgsrc'] = $imgsrc;
		$IframeoutputArr['iframeulliArr'] =json_encode( $newIframeuili);
		return $IframeoutputArr;
	}
	
	

// get table value end---------
$itemTitle=str_replace("<span class=\"g-hdn\">Details about  &nbsp;</span>", "", $itemTitle);
$outputArr['MainTitle'] =$itemTitle;
$outputArr['Mainiframesrc'] = $iframesrc;
$outputArr['MainImgSrc'] = $src;
$outputArr['MainTable'] = json_encode($MainTableArr);
$outputArr['itemID'] = $itemID;
$outputArr['MainPrice'] = $prcIsum;
date_default_timezone_set('America/Chicago');
$outputArr['timestemp'] =date('Y-m-d H:i:s');

$result = array_merge($outputArr, $getIframeData);

$html->clear();

//insert
$keys=array();
$values=array();
 foreach ($result as $key => $value) {
        array_push($keys, $key);
        array_push($values, addslashes($value));
    }
$insertStatus='Success';
$res = mysqli_query($link, "INSERT INTO download_listing_content (" . implode(", ", $keys) . ") VALUES ('" . implode("', '", $values) . "')"); // insert one row into new table
    if ($res) {
       $insertStatus="Success";
        
    } else {
        echo("INSERT INTO download_listing_content (" . implode(", ", $keys) . ") VALUES ('" . implode("', '", $values) . "')");
        $insertStatus='failed';
    }
	
	echo json_encode(array('result'=>$result,'insertStatus'=>'Success'));


?>