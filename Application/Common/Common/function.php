<?php

/**
 * @Author: Administrator
 * @Date:   2017-12-21 10:41:34
 * @Last Modified by:   Administrator
 * @Last Modified time: 2017-12-21 10:44:19
 */

function turnTo($url){
//    echo "<!--<scrīpt LANGUAGE='Javascrīpt'>";
//    echo "location.reload='$url'";
//    echo "</scrīpt>-->";
    header("Location:$url");
}

function jRet($val, $die=0){
    echo json_encode($val);
    if($die){die();}

}

function j($arr, $die=0){
    echo json_encode($arr);
    if($die){die();}
}

function mbStrSplit ($string, $len=1, $fir=1) {
    if($fir){
        $start = 0;
        $strlen = mb_strlen($string);
        while ($strlen) {
            $array[]    = mb_substr($string,$start,$len,"utf8");
            $string     = mb_substr($string, $len, $strlen,"utf8");
            $strlen     = mb_strlen($string);
        }
        return $array;
    }else{
        $start = 0;
        $strlen = mb_strlen($string);
        while ($strlen) {
            $array[]    = mb_substr($string,$start,$len,"utf8");
            $string     = mb_substr($string, $len, $strlen,"utf8");
            $strlen     = mb_strlen($string);
        }
        return $array['0'];
    }

}

function getCard($card){
    $cards = json_decode($card);
    if (is_array($cards)){
        return implode(" | ", $cards);
    }
    return $card;
}

function p($arr, $die=0, $detail=''){
    header('Content-type:text/html;charset=utf-8');
    if ($detail) {
        $detail = '【'.$detail.'】';
    }
    $count = count($arr);
    echo "<pre>";
    echo '详细打印'.$detail.$count.'条记录>>开始<br/>';
    if ($arr) {
        print_r($arr);
    } else {
        echo $detail. '<strong style=color:#ff0344>暂无数据！！！</strong>';
    }
    echo "<br/>";
    echo '详细打印'.$detail.'>>结束<br/>';
    echo "<br/><br/>";
    if($die){die();}
}

function pLog($value, $detail = '调试日志', $name = 'logs.txt', $dir = './logs/'){
    if (is_array($value)) {
        $value = json_encode($value, JSON_UNESCAPED_UNICODE);
    }
    $file = $dir.$name;
    if (file_exists($file)){
        // if (filesize($file) >= env('LOG_FILE_SIZE')) {
        //     unlink($file);
        // }
    } else {
        if (!file_exists($dir)){
            mkdir($dir);
        }
        fopen($file, 'w');
    }
    $value = '【'.date('Y-m-d H:i:s').'】'.$detail.PHP_EOL.$value.PHP_EOL;
    file_put_contents($file, $value.PHP_EOL, FILE_APPEND);
}

function utf8()
{
    return header('Content-type:text/html;charset=utf-8');
}

function tree($directory)
{
    $mydir = dir($directory);
    echo "<ul>\n";
    while($file = $mydir->read())
    {
        if((is_dir("$directory/$file")) AND ($file!=".") AND ($file!=".."))
        {
            tree("$directory/$file");
        }
        elseif (($file!=".") AND ($file!="..")) {
            $res = explode('.', $file);
            $name = explode('/', $file);
            if (end($res) == 'torrent') {
                // echo filesize($directory.'/'.$file).'<br/>';
                echo $directory.'/'.$file.'<br/>';
                echo end($name).'<br/>';
            }
        }
    }
    echo "</ul>\n";
    $mydir->close();
}
