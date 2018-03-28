<?php
/**
 * Created by PhpStorm.
 * User: Maibenben
 * Date: 2018/3/28
 * Time: 12:39
 */

namespace Home\Controller;


use Think\Controller;

class GetdescController extends Controller
{
    public function insertDesc(){
        $res    = M('res');
        $start  = $res->where(['res_desc'=>''])->limit(10)->select();
        $sId    = $start[0]['id'];
        for($i=$sId; $i<$sId+11; $i++){

        }

        $desc   = $this->getDesc($url);

    }

    protected function getDesc($url){
        utf8();
//        $bc = new execBt();
        $bc = new \Org\Util\ExecBt();
        //使用实例
        $s = curl($url);
//        $s  =   curl('http://oov8vybfo.bkt.clouddn.com/btsdee/149295965216750.torrent');
        $bc->init();
        $bc->decode($s, strlen($s));
        $info = array();
        if (is_object($bc->y)) {
            if(property_exists($bc->y->info, 'files')){
                $res = $bc->y->info->files;
                foreach ($res as $v) {
                    foreach ($v as $key => $value) {
                        if ($key == 'path.utf-8') {
                            if (!strstr($value[0], '如果您看到此文件')) {
                                if (!empty($value[1])) {
                                    $value[0] = $value[0].'/'.$value[1];
                                }
                                array_push($info, $value[0]);
                            }
                        }
                    }
                }
            }
        }
        $res='';
        $sum    = count($info);
        for ($i=0; $i <$sum ; $i++) {
            if($i==$sum-1){
                $res.=$info[$i];
            }else{
                $res.=$info[$i]."|";
            }

        }

//        var_dump($res);
        return $res;
    }
}