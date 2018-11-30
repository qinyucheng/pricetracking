<?php


/*
 * php读取文件夹内文件及文件夹
 * 参数：文件夹路径$dir，格式要求：文件夹名称后必须有“/”
 * 返回值：含有文件名称和路径的一维数组
 */


function read($dir) {
    $dir_tem = $dir;      //用于最终的路径拼接，解决乱码和不显示的bug
    $dir = iconv('utf-8', 'gb2312', $dir);    //对参数路径进行gb2312转码
    $data = scandir("$dir");    //返回指定目录中的文件和目录的数组。
    $file_arr = array();        //暂存文件列表
    $dir_arr = array();         //暂存文件夹内的文件列表
    foreach ($data as $file) {
        if (is_dir($dir . $file) && $file != '.' && $file != '..') {    //判断是否是文件夹内的文件夹
            $file = iconv('gb2312', 'utf-8', $file);    //对中文的文件夹进行转码
            $dir_arr[] = read($dir . $file . "/");      //递归读取文件夹内的文件
			
        } else {
            $file = iconv('gb2312', 'utf-8', $file);     //讲文件名转换为utf8编码，防止乱码
            $dir = iconv('gb2312', 'utf-8', $dir);
            if ($file != '.' && $file != '..') {     //过滤
                $file_arr[] = $dir_tem . $file;
            }        //进行路径拼接
        }
    }
    $allFile = array_merge($file_arr, $dir_arr);   //拼合数组
    return $allFile;
}


function rebuild_array($arr) {  //将多维数组变为一维数组
    static $tmp = array();      //此处为静态变量，防止递归的时候数据丢失
    for ($i = 0; $i < count($arr); $i++) {
        if (is_array($arr[$i]))
            rebuild_array($arr[$i]);  //递归
        else
            $tmp[] = $arr[$i];
    }
    return $tmp;
}


function getFile($arr) {
    $data = read($arr);
    return rebuild_array($data);
}

$filesArr=getFile('C:\Users\LibraIT01\Desktop\Scrapy\AmazonIpone6Spider-master\AmazonIphone6\amazon\\');
echo json_encode($filesArr);


?>