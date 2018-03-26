<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/1
 * Time: 17:30
 */
namespace Admin\Controller;

use Think\Controller;

define("TOKEN", "masterOnline");//定义你公众号自己设置的token
define("APPID", "wx70767e94112af8d7");//填写你微信公众号的appid 千万要一致啊
define("APPSECRET", "bfcfa6dbd29815705e8384ca2a045d26");//填写你微信公众号的appsecret  千万要记得保存 以后要看的话就只有还原了  保存起来 有益无害
class WxController extends Controller
{

    public function test(){
    }

    //判断是介入还是用户  只有第一次介入的时候才会返回echostr
    function index()
    {
        Vendor('Weixin.wechatClass');
            $options = array(
                'token'=>TOKEN //填写你设定的key
            );
            $weObj = new \Wechat($options);
//            $weObj->valid(); //注意, 应用验证通过后,可将此句注释掉, 但会降低网站安全性
            $type = $weObj->getRev()->getRevType();
            switch($type) {
                case $weObj::MSGTYPE_TEXT:
                    $all    = $weObj->getAll();
                    $info   = explode('+', $all['Content']);
                    if(count($info) == 4 && $info['0'] == '福袋'){
                        $db =$info[1].".user";
                        pLog($db, 'db');
                        $userModel  = M($db);
                        $uid        = $userModel->where(['uid'=>$info['3']])->getField('uid, guanzhuStatus');
                        pLog($userModel->getLastSql(),'debug');
                        if($uid){
                            pLog($uid, 'uidRequest');
                            foreach($uid as $k => $v){
                                if($v){
                                    $msgs   = "谢谢关注，但是只能赠送一次！将活动链接分享给其他好友，可以领取更多抽奖机会！【点我返回活动：https://".$info[1].".hunanmaster.com/index.php?s=/Home/Index/huodong/id/".$info[2]."/uid/".$info[3].".Power_by_deelian】";
                                }else{
                                    $where      = [
                                        'huodongId'     => $info['2'],
                                        'userId'        => $k
                                    ];
                                    $res        = M($info[1].'.cards_list')->where($where)->setInc('times', 5);
                                    if($res){
                                        $rs = $userModel->where(['uid'=>$info['3']])->save(['guanzhuStatus'=>1]);
                                        if($rs){

                                            $msgs   = "系统已成功为用户:" .$info['3']."增加5次抽奖机会！好运……【点我返回活动：https://".$info[1].".hunanmaster.com/index.php?s=/Home/Index/huodong/id/".$info[2]."/uid/".$info[3].".Power_by_deelian】";

                                        }else{
                                            $msgs   = '错误…… 请稍后重试！';
                                        }
                                    }else{
                                        $msgs       = "错误！请检查活动ID，确认无误后重试！";
                                    }
                                }
                            }
                        }else{
                            $msgs   = '回复消息错误，请重试！';

                        }

                    }else{
                        $msgs   = '回复消息错误，请检查！';
                    }

                    pLog($all, '收到消息', 'wxMsg.logs');
                    $weObj->text($msgs)->reply();
                    exit;
                    break;
                case $weObj::MSGTYPE_EVENT:
                    $weObj->text("回复：福袋+活动ID+用户名，领取更多抽奖机会")->reply();
                    break;
                case $weObj::MSGTYPE_IMAGE:
                    $weObj->text("回复：福袋+活动ID+用户名，领取更多抽奖机会")->reply();
                    break;
                default:
                    $weObj->text("回复：福袋+站识别号+活动ID+用户名，领取更多抽奖机会")->reply();
            }
        //这个echostr呢  只有说验证的时候才会echo  如果是验证过之后这个echostr是不存在的字段了
//        $echoStr = $_GET["echostr"];
//        if ($this->checkSignature()) {
//            echo $echoStr;
//            //如果你不知道是否验证成功  你可以先echo echostr 然后再写一个东西
//            exit;
//        }
    }//index end

    //验证微信开发者模式接入是否成功
    private function checkSignature()
    {
        //signature 是微信传过来的 类似于签名的东西
        $signature = $_GET["signature"];
        //微信发过来的东西
        $timestamp = $_GET["timestamp"];
        //微信传过来的值  什么用我不知道...
        $nonce     = $_GET["nonce"];
        //定义你在微信公众号开发者模式里面定义的token
        $token  = "masterOnline";
        //三个变量 按照字典排序 形成一个数组
        $tmpArr = array(
            $token,
            $timestamp,
            $nonce
        );
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        //哈希加密  在laravel里面是Hash::
        $tmpStr = sha1($tmpStr);
        //按照微信的套路 给你一个signature没用是不可能的 这里就用得上了
        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }// checkSignature end
    //构建一个发送请求的curl方法  微信的东西都是用这个 直接百度
    function https_request($url, $data = null)
    {
        //这个方法我不知道是怎么个意思  我看都是这个方法 就copy过来了
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

//    public function dee(){
//        $encodingAesKey = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFG";
//        $token = "pamtest";
//        $timeStamp = "1409304348";
//        $nonce = "xxxxxx";
//        $appId = "wxb11529c136998cb6";
//        $text = "<xml><ToUserName><![CDATA[oia2Tj我是中文jewbmiOUlr6X-1crbLOvLw]]></ToUserName><FromUserName><![CDATA[gh_7f083739789a]]></FromUserName><CreateTime>1407743423</CreateTime><MsgType><![CDATA[video]]></MsgType><Video><MediaId><![CDATA[eYJ1MbwPRJtOvIEabaxHs7TX2D-HV71s79GUxqdUkjm6Gs2Ed1KF3ulAOA9H1xG0]]></MediaId><Title><![CDATA[testCallBackReplyVideo]]></Title><Description><![CDATA[testCallBackReplyVideo]]></Description></Video></xml>";
//
//
//        $pc = new WXBizMsgCrypt($token, $encodingAesKey, $appId);
//        $encryptMsg = '';
//        $errCode = $pc->encryptMsg($text, $timeStamp, $nonce, $encryptMsg);
//        if ($errCode == 0) {
//            print("加密后: " . $encryptMsg . "\n");
//        } else {
//            print($errCode . "\n");
//        }
//
//        $xml_tree = new DOMDocument();
//        $xml_tree->loadXML($encryptMsg);
//        $array_e = $xml_tree->getElementsByTagName('Encrypt');
//        $array_s = $xml_tree->getElementsByTagName('MsgSignature');
//        $encrypt = $array_e->item(0)->nodeValue;
//        $msg_sign = $array_s->item(0)->nodeValue;
//
//        $format = "<xml><ToUserName><![CDATA[toUser]]></ToUserName><Encrypt><![CDATA[%s]]></Encrypt></xml>";
//        $from_xml = sprintf($format, $encrypt);
//
//// 第三方收到公众号平台发送的消息
//        $msg = '';
//        $errCode = $pc->decryptMsg($msg_sign, $timeStamp, $nonce, $from_xml, $msg);
//        if ($errCode == 0) {
//            print("解密后: " . $msg . "\n");
//        } else {
//            print($errCode . "\n");
//        }
//    }



}