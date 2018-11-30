<?php
include_once('simple_html_dom.php');


$html = new simple_html_dom();
//$html->load_file('https://www.ebay.com/sch/Wheels-Tires/43983/m.html?_nkw=&_armrs=1&_from=&_ssn=atvmaster&_pgn=1&_skc=50&rt=nc');
$html->load_file('https://www.ebay.com/sch/atvmaster/m.html?_nkw=&_armrs=1&_ipg=&_from=');
$listIDArr=array();
$Arr=array();
//get saler Name
$sellerNameDiv = $html->find('div[id=soiCont]',0);
$sellerNameAtag = $sellerNameDiv->find('.mbid',0);
$sellerName=$sellerNameAtag->plaintext;
$Arr['sellerName']=$sellerName;
$pageArr=array();
//echo $sellerName.'<br>';

//get list ID
$ret = $html->find('ul[id=ListViewInner]',0);
$liArr = $ret->find('li');

foreach ($liArr as $i) {
	
	$listID = $i ->getAttribute('listingid');
	if($listID!='')
	{
		//echo $listID.'<br>';
		$Arr['listID']=$listID;
		$title = $i->find('.vip',0)->plaintext;
		$Arr['title']=$title;
		//array_push($listIDArr,$listID);
		array_push($listIDArr,$Arr);
		
		//echo $title.'<br>';
	}
	//get sold number 
	$soldInfoUl=$i->find('.lvprices',0);
	if($soldInfoUl!='')
	{
		$soldli=$soldInfoUl->find('.lvextras',0);
		
		//echo $soldInfoUl;
		if($soldli!='')
		{
		$soldNumO=$soldli->find('.hotness-signal',0);
		if($soldNumO!='')
		{
			$soldNum=$soldNumO->plaintext;
			$Arr['soldNum']=trim($soldNum);
		}
		
		//print $soldNum.'<br><br>';
		}
		
	}
	
	
}


//get next page
$pgCtrlTbl = $html->find('table[id=Pagination]', 0);
$tdPages = $pgCtrlTbl->find('.pages', 0);
$ret = $tdPages->find('a');
foreach($ret as $a)
{
	
	//print $a->getAttribute('href').'<br>';
	array_push($pageArr,$a->getAttribute('href'));
}
$html->clear();
//echo json_encode(array('listIDArr'=>$listIDArr,'pageArr'=>$pageArr,'info'=>$Arr));
echo json_encode( $listIDArr);
//echo json_encode(array('listIDArr'=>'1','pageArr'=>'3','info'=>'3'));



?>