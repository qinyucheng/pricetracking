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
$Path = trim($_POST['amazon_Path']);
//$url = "C:/Users/LibraIT01/Desktop/Scrapy/amazon_item/AmazonIphone6/amazon/B07JKY4FZZ.html";
//$url = "C:/Users/LibraIT01/Desktop/Scrapy/amazon_item/AmazonIphone6/amazon/B079QBK6YQ.html";
//$url = "C:/Users/LibraIT01/Desktop/Scrapy/amazon_item/AmazonIphone6/amazon/B0764GFJTS.html";



function listFolderFiles($dir=null)
{
    $rtn = array();
    if (is_dir($dir)) {
        #echo '<ol>';
        foreach (new DirectoryIterator($dir) as $fileInfo) {
            if (!$fileInfo->isDot()) {
               // echo '<li>' . $fileInfo->getFilename();

                if ($fileInfo->isDir()) {
                    //echo 'directory';
                    //$rtn = array_merge($rtn, listFolderFiles($fileInfo->getPathname()));
                } else {
                    //echo 'file';
                    //$rtn[] = $fileInfo->getFilename();
					$url= $dir.$fileInfo->getFilename();
					$rtn[] =$url;
					
                }
                #echo '</li>';
            }
        }
        #echo '</ol>';
    } else {
        echo "No such directory '$dir'";
    }
    return $rtn;
}
//$result = listFolderFiles('C:\Users\LibraIT01\Desktop\Scrapy\AmazonIpone6Spider-master\AmazonIphone6\ebay\\');
$amazonList = listFolderFiles($Path);

echo json_encode($amazonList)
 
?>