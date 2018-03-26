<?php
/**
 * Created by PhpStorm.
 * User: Maibenben
 * Date: 2017/12/23
 * Time: 0:14
 */
namespace Admin\Controller;

use Think\Controller;

Class VerifyController extends Controller
{


    function _initialize(){

    }

    public function getVerify(){

        $config =    array(
            'imageH'      =>    40,
            'codeSet'     =>    '0123456789',
            'fontSize'    =>    18,    // 验证码字体大小
            'length'      =>    4,     // 验证码位数
            'useNoise'    =>    false, // 关闭验证码杂点
            );
        $Verify = new \Think\Verify($config);
        $Verify->entry('Login');
    }

    public function checkVerify($code)
    {
        $verify = new \Think\Verify();
        return $verify->check($code, 'Login');
    }
}