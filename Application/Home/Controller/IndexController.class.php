<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function __construct()
    {
        set_time_limit(0);
    }

    public function index(){
        require_once '/usr/local/xunsearch/sdk/php/lib/XS.php';

        $total_begin = microtime(true);
        $xs = new \XS('xiakexing');
//        p($xs);
//        p(I());
//        extract(I());
//        p($p, 1);


        $s = 'relevance';
        $f = '_all';

        $search = $xs->search;
        $search->setCharset('UTF-8');
        $q  = I('q');

        if (empty($q)) {
            // just show hot query
            $hot = $search->getHotQuery();
        } else {
            // fuzzy search
            $search->setFuzzy($m === 'yes');

            // synonym search
            $search->setAutoSynonyms($syn === 'yes');

            // set query
            if (!empty($f) && $f != '_all') {
                $search->setQuery($f . ':(' . $q . ')');
            } else {
                $search->setQuery($q);
            }

            // set sort
            if (($pos = strrpos($s, '_')) !== false) {
                $sf = substr($s, 0, $pos);
                $st = substr($s, $pos + 1);
                $search->setSort($sf, $st === 'ASC');
            }

            // set offset, limit
            $p = max(1, intval($p));
            $n = XSSearch::PAGE_SIZE;
            $search->setLimit($n, ($p - 1) * $n);

            // get the result
            $search_begin = microtime(true);
            $docs = $search->search();
            $search_cost = microtime(true) - $search_begin;

            p($docs);

            // get other result
            $count = $search->getLastCount();
            $total = $search->getDbTotal();

            if ($xml !== 'yes') {
                // try to corrected, if resul too few
                if ($count < 1 || $count < ceil(0.001 * $total)) {
                    $corrected = $search->getCorrectedQuery();
                }
                // get related query
                $related = $search->getRelatedQuery();
            }

            // gen pager
            if ($count > $n) {
                $pb = max($p - 5, 1);
                $pe = min($pb + 10, ceil($count / $n) + 1);
                $pager = '';
                do {
                    $pager .= ($pb == $p) ? '<li class="disabled"><a>' . $p . '</a></li>' : '<li><a href="' . $bu . '&p=' . $pb . '">' . $pb . '</a></li>';
                } while (++$pb < $pe);
            }
        }
    }

    public function loadOnline()
    {
        header('Content-type:text/html;charset=utf-8');
        $User = M('bt','my_','DB_OLD2'); 
        $map['id'] = array(array('gt',0),array('lt',10001), 'and') ;

        $select = 'btname AS res_name, bturl AS res_links';

        $rs     = $User->where($map)->field($select)->select();
        foreach ($rs as $k => $v) {
            $arr    = explode('/', $v['res_links']);

            $rs[$k]['res_dirs']    =  $arr[0];
            $rs[$k]['res_links']    =  $arr[1];
            $rs[$k]['show_times'] =  rand(1000, 9999);
            $rs[$k]['add_time']   =  time();
        }
        // p($rs);
        p(M('res')->addAll($rs));
        // $this->scanMyDir($path);
    }

    public function scanMyDir($path, $dir)
    {
        // p(iconv_get_encoding(),1);
        // 打开目录
        $dh = opendir($path.$dir);
        $res = M('res');
        mkdir('../onLine/'.$dir, 0777, true);
        $i=0;
        // 循环读取目录
        while(($file = readdir($dh)) !== false){
            // 先要过滤掉当前目录'.'和上一级目录'..'
            if($file == '.' || $file == '..') continue;
            // 为了能够显示中文目录/文件，需要进行转码
            // echo '<li>'.iconv('gbk','utf-8',$file).'</li>';
            // p($path.'/'.$file);
            // 如果该文件仍然是一个目录，进入递归
//            if(is_dir($path.'/'.$file)){
//                mkdir($path.'_test/'.$file, 0777, true);
//                self::scanMyDir($path.'/'.$file);
//            }else{
                $name = explode('.torrent', $file);
                // $encode     = ['Unicode',"ASCII",'UTF-8',"GB2312","GBK",'BIG5','CP936','Base64','MBCS'];
                // $encode = mb_detect_encoding($name, $encode); 
                // p($encode);
                // $name = mb_convert_encoding($name, 'UTF-8', $encode);
                $link = rand(1000, 9999).time().'.torrent';

                if (rename($path.$dir.'/'.$file, '../onLine/'.$dir.'/'.$link)) {

//                    echo "d";
                    $data = [
                        'res_name'  =>  $name[0],
                        'res_links' =>  $link,
                        'res_dirs'  =>  $dir,
                        'show_times'=>  rand(10000, 99999),
                        'add_time'  =>  time()
                    ];
                    $rs = $res->add($data);
                    $i++;
//                    pLog($res->getLastSql());
                }
//            }
        }
        echo $i;
    }





    public function indexer()
    {
        $res    = M('bt','my_','DB_OLD2');
        $list   =   $res->where(['id'=>['lt',100]])->select();
        p($list);
    }
}
