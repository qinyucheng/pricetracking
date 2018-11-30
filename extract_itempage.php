<?php
include_once('simple_html_dom.php');
$itemID = $_GET['action'];
$itemurl='https://www.ebay.com/itm/'.$itemID;
//$itemurl='https://www.ebay.com/itm/390530456928';https://www.ebay.com/itm/272805421977
$Arr=array();
$html = new simple_html_dom();
$html->load_file($itemurl);
$prcO = $html->find('span[id=prcIsum]', 0);

$prc=$prcO ->getAttribute('content');
//echo $prc;
$Arr['$prc']=$prc;

$qtySubTxt = $html->find('span[id=qtySubTxt]', 0);
$spanLink = $html->find('span[class=vi-qtyS]', 0);
$tagA=$spanLink->find('a',0);
$href = $tagA ->getAttribute('href');
echo ($href);



?>