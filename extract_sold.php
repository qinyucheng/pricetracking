<?php
include_once('simple_html_dom.php');
$itemid = $_GET['action'];
$itemurl ='https://offer.ebay.com/ws/eBayISAPI.dll?ViewBidsLogin&item='.$itemid.'&rt=nc&_trksid=p2047675.l2564';
print $itemurl;
$html = new simple_html_dom();
//$html->load_file('https://offer.ebay.com/ws/eBayISAPI.dll?ViewBidsLogin&item=352410532186&rt=nc&_trksid=p2047675.l2564');
$html->load_file($itemurl);

$tableDiv = $html->find('div[class=BHbidSecBorderGrey]', 0);
$table = $tableDiv->find('table',1);

$rowData = array();

foreach($table->find('tr') as $row) {
    // initialize array to store the cell data from each row
    $flight = array();
    foreach($row->find('td') as $cell) {
        // push the cell's text to the array
        $flight[] = $cell->plaintext;
    }
    $rowData[] = $flight;
}

$kvArr=array();
foreach ($rowData as $row => $tr) {
    $valueArr=array();
	$count=0;
    foreach ($tr as $td)
	{
		
		
		if($td!='')	
		{
				if($count==2)
				{
					$newtd = preg_replace("/[\n\r\t]/","",$td); 
					$valueArr['Price']=$newtd;
				}if($count==3)
				{
					$newtd = preg_replace("/[\n\r\t]/","",$td); 
					$valueArr['Quantity']=$newtd;
				}if($count==4)
				{
					$newtd = preg_replace("/[\n\r\t]/","",$td); 
					$valueArr['Date ']=$newtd;
				}
				
				
			
		}
      $count++;
	}
	array_push($kvArr,$valueArr);
		//print_r($valueArr);
		//print '<br>';
}

$html->clear();
echo json_encode($kvArr);



?>