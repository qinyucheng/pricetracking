<?php // display source code  

try{
//$lines = file('https://www.amazon.com/s/ref=nb_sb_ss_i_3_11?url=search-alias%3Daps&field-keywords=atv+tires+25x8x12&sprefix=atv+tires+2%2Caps%2C161&crid=3I11Q85O1UPOG');  
//$lines = file('https://www.amazon.com/s/ref=nb_sb_noss_2?url=search-alias%3Daps&field-keywords=atv+tires+25x8-12+25x10-12&rh=i%3Aaps%2Ck%3Aatv+tires+25x8-12+25x10-12');  
//$lines = file('https://www.amazon.com/s/ref=nb_sb_noss_2?url=search-alias%3Daps&field-keywords=atv+tires+22x7-11+22x10-9');  
//$lines = file('https://www.amazon.com/s/ref=nb_sb_noss_2?url=search-alias%3Daps&field-keywords=trailer+tire+205+75R15&rh=i%3Aaps%2Ck%3Atrailer+tire+205+75R15');  
//$lines = file('https://www.amazon.com/s/ref=nb_sb_noss_1?url=search-alias%3Daps&field-keywords=trailer+tire+205+75R14&rh=i%3Aaps%2Ck%3Atrailer+tire+205+75R14');  
//$lines = file('https://www.amazon.com/s/ref=nb_sb_noss_2?url=search-alias%3Daps&field-keywords=24%22+RV+stabilizer+jack&rh=i%3Aaps%2Ck%3A24%22+RV+stabilizer+jack');  
//$lines = file('https://www.amazon.com/s/ref=nb_sb_noss_2?url=search-alias%3Daps&field-keywords=5+on+4.5+trailer+brake+drum&rh=i%3Aaps%2Ck%3A5+on+4.5+trailer+brake+drum');  
//$lines = file('https://www.amazon.com/s/ref=nb_sb_noss?url=search-alias%3Daps&field-keywords=8+on+6.5+trailer+brake+drum&rh=i%3Aaps%2Ck%3A8+on+6.5+trailer+brake+drum');  
//$lines = file('https://www.amazon.com/s/ref=nb_sb_noss_2?url=search-alias%3Daps&field-keywords=12+x+2+trailer+brake&rh=i%3Aaps%2Ck%3A12+x+2+trailer+brake');  
//$lines = file('https://www.amazon.com/s/ref=nb_sb_noss_2?url=search-alias%3Daps&field-keywords=10%22+trailer+brake&rh=i%3Aaps%2Ck%3A10%22+trailer+brake');  

$lines = stripslashes(trim($_POST['URL']));
$tag = stripslashes(trim($_POST['TAG']));
$t=time();
$filePath="";
$filePath .="amazon_search/".$tag;
file_put_contents($filePath,$lines);
echo "Download Successful!";
}
catch(Exception $e)
{
	
	 echo 'Caught exception: ',  $e->getMessage(), "\n";
}
	
?>