<?php
namespace Home\Controller;

use Think\Controller;

class AppController extends Controller
{
    public function loginOut(){
        session_destroy();
        session_unset();
    }

    public function login(){
        if(IS_POST){
            $user   = M('user');
            if($_POST['handle']){
                $check      = $user->where(['account'=>$_POST['account']])->find();
                if($check){
                    jRet([
                        'status'    => 'false',
                        'msg'       => '该账号已被注册！换一个吧……'
                    ]);
                }else{
                    $subData    = [
                        'account'   => $_POST['account'],
                        'passWd'    => md5($_POST['passWd']),
                        'openId'    => time(),
                        'addTime'   => time(),
                        'lastLogin' => time()
                    ];
                    $rs         = $user->add($subData);
                    if($rs){
                        // cookie('uid', $rs, 3600*24*90);
                        session('uid', $rs);
                        if(I('tuiUser')>0){
                            $incTime    = M('cardsList');
                            $where      = [
                                'huodongId'     => I('tuiDong'),
                                'userId'        => I('tuiUser')
                            ];
                            $incRs      = $incTime->where($where)->setInc('times', 5);
                        }
                        jRet([
                            'status'    => 'done',
                            'msg'       => '注册成功！正在进入系统……',
                            'url'       => U('home/index/home')
                        ]);
                    }
                }
            }else{
                $rs     = $user->where(['account' => $_POST['account']])->find();
//                pLog(md5($_POST['passWd']), 'login');
                if(is_array($rs) && md5($_POST['passWd']) == $rs['passwd']){
                    // cookie('uid', $rs, 3600*24*90);
                    session('uid', $rs['uid']);
                    jRet([
                        'status'        => 'done',
                        'msg'           => '登录成功！正在进入系统……',
                        'url'           => U('home/Index/home')
                    ]);
                }else{
                    jRet([
                        'status'    => 'false',
                        'msg'       => '账号或密码错误，请检查……'
                    ]);
                }
            }
        }else{

            if(I('uid')){
                $this->assign('tuijian', I());
            }else{
                $this->assign('tuijian', 0);
            }

            $this->assign('url', U());
            $this->display();
        }
    }
}