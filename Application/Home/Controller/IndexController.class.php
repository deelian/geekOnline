<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function __construct()
    {
        set_time_limit(0);
    }

    public function loadOnline()
    {
        header('Content-type:text/html;charset=utf-8');
        $User = M('bt','my_','DB_OLD2'); 
        $map['id'] = array(array('gt',10000),array('lt',19999), 'and') ;

        $select = 'btname AS res_name, bturl AS res_links';

        $rs     = $User->where($map)->field($select)->select();
        foreach ($rs as $k => $v) {
            $arr    = explode('/', $v['res_links']);

            $rs[$k]['res_tags']    =  $arr[0];
            $rs[$k]['res_links']    =  $arr[1];
            $rs[$k]['show_times'] =  rand(1000, 9999);
            $rs[$k]['add_time']   =  time();
        }
        // p($rs);
        p(M('res')->addAll($rs));
        // $this->scanMyDir($path);
    }

    public function scanMyDir($path)
    {
        // p(iconv_get_encoding(),1);
        // 打开目录
        $dh = opendir($path);
        $res = M('res');
        // 循环读取目录
        while(($file = readdir($dh)) !== false){
            // 先要过滤掉当前目录'.'和上一级目录'..'
            if($file == '.' || $file == '..') continue;
            // 为了能够显示中文目录/文件，需要进行转码
            // echo '<li>'.iconv('gbk','utf-8',$file).'</li>';
            // p($path.'/'.$file);
            // 如果该文件仍然是一个目录，进入递归
            if(is_dir($path.'/'.$file)){
                mkdir($path.'_test/'.$file, 0777, true);
                self::scanMyDir($path.'/'.$file);
            }else{
                $name = explode('.torrent', $file);
                // $encode     = ['Unicode',"ASCII",'UTF-8',"GB2312","GBK",'BIG5','CP936','Base64','MBCS'];
                // $encode = mb_detect_encoding($name, $encode); 
                // p($encode);
                // $name = mb_convert_encoding($name, 'UTF-8', $encode);
                $link = rand(1000, 9999).time().rand(1000, 9999).'.torrent';
                if (rename($path.'/'.$file, $path.'/'.$link)) {

                    echo "d";
                    $data = [
                        'res_name'  =>  $name[0],
                        'res_links' =>  $link,
                        'res_tags'  =>  basename(dirname($path.'/'.$link)),
                        'show_times'=>  rand(1000, 9999),
                        'add_time'  =>  time()
                    ];
                    $rs = $res->add($data);
                    pLog($res->getLastSql());
                }
            }
        }
    }

    public function downLoad(){
//        $bc = new execBt();
        $bc = new \Org\Util\ExecBt();
        //使用实例
//        $s = myFunc::curl($url);
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

    }

    public function indexer()
    {
        $res    = M('bt','my_','DB_OLD2');
        $list   =   $res->where(['id'=>['lt',100]])->select();
        p($list);
    }
}
