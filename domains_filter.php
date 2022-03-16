<?php

/*
 * 删除域名筛选器，筛选4字母以下和指定关键字域名
 * BY：0x1818
 * date：2017/12/25
 */
//获取当前日期并获取删除域名内容；
$date = date("Y-m-d");
 //下载今天的被删除域名列表
 /**
 格式：
 a.com
 b.com
 c.com
 **/
$url = "http://www.namejet.com/download/" . $date . ".txt"; 
$str = file_get_contents($url);
$begin = "<pre>";
$end = "</pre>";
$b = mb_strpos($str, $begin) + mb_strlen($begin);
$e = mb_strpos($str, $end) - $b;
$tmp = mb_substr($str, $b, $e);

//写入到临时文件tmp.txt中

$file1 = fopen("tmp.txt", "w");
fwrite($file1, $tmp);
fclose($file1);

//打开临时文件，读取每一行的域名信息
    $file2 = fopen("tmp.txt", "r");
//创建域名关键字数组，进行比对
    $array = ["red", "green", "blue", "black", "white",
        "lion", "fox", "tiger", "panda", "wolf", "bull", "cow", "deer", "snake", "shark", "ant",
        "air", "tool", "trip", "play", "game", "box", "name", "fun", "joy",
        "one", "two",
        "le", "qu", "dou", "duo", "che", "fang", "ku", "dan", "ji", "ke", "du", "wan", "pai", "ju", "bei", "fei", "jia", "mei", "guai"];

    $file3 = $date . ".txt";

    while (!feof($file2)) {
        //读取一行域名
        $line = fgets($file2);
        //创建删除域名文件
        //如果域名长度小于8个说明是四字母域名，以换行追加形式写入到域名文件中
        if (strpos($line, ".cc") === FALSE) {
            if (strlen($line) < 9) {
                echo $line . "<br />";

                file_put_contents($file3, $line . PHP_EOL, FILE_APPEND);
            }
            //查找每行域名是否含有关键字，如果含有关键字，以换行追加形式写入到域名文件
            foreach ($array as $value) {

                if (strstr($line, $value) && strlen($line) < 16) {

                    echo $line . "<br />";

                    file_put_contents($file3, $line . PHP_EOL, FILE_APPEND);
                }
            }
        }
    }

//关闭域名文件
    fclose($file2);
