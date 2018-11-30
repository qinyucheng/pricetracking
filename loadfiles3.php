<?php
$amazon_Path = trim($_POST['amazon_Path']);
$ebay_Path = trim($_POST['ebay_Path']);
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
                    $rtn[] = $fileInfo->getFilename();
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
$amazonList = listFolderFiles($amazon_Path);
$ebayList = listFolderFiles($ebay_Path);


echo json_encode(array("amazon" => $amazonList, "ebay" => $ebayList))
?>