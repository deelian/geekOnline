<?php
/**
 * Created by PhpStorm.
 * User: Maibenben
 * Date: 2018/1/22
 * Time: 13:42
 */
namespace Admin\Controller;

use Think\Controller;

class HuodongController extends Controller
{

    public function huodongEdit(){

        $huodong    = M('huodong');
        if(IS_POST){

            $subData    = [
                'id'            => I('id'),
                'title'         => I('title'),
                'num'           => I('num'),
                'ruler'         => I('ruler'),
                'endTime'       => strtotime(I('endTime')),
                'gift'          => I('gift'),
                'desHuodong'    => I('desHuodong'),
                'cardName'      => json_encode(mbStrSplit(I('cardName'))),
                'owner'         => I('owner'),
                'cooperation'   => I('cooperation')
            ];

            if($_FILES['Filedata']['name'] != ''){
                $banner                     = $this->upload();
                $subData['bannerImg']       = $banner['savepath'].$banner['savename'];
            }
            $rs     = $huodong->data($subData)->save();
//            p($huodong->getLastSql());
//            if($rs){
//            $this->success('操作完成','/Admin/Huodong/huodongList',3);
            echo('操作完成');
//            jRet([
//                'status'    => 'done',
//                'msg'       => '修改成功！'
//            ]);
        }else{
            $rs                 = $huodong->where(['id'=>I('id')])->find();
            $rs['cardname']     = implode('',json_decode($rs['cardname']));
            $rs['endtime']      = date("Y-m-d H:i", $rs['endtime']);
//            p($rs);
            $this->assign('rs', $rs);
            $this->display('editHuodong');
        }
    }

    public function addHuodong(){
        if (IS_POST ){
            $huodong   = M('huodong');

            $banner                 = $this->upload();
            $_POST['cardName']      = json_encode(mbStrSplit($_POST['cardName']));
            $_POST['endTime']       = strtotime($_POST['endTime']);
            $data                   = $_POST;
            $data['startTime']      = time();
            $data['bannerImg']      = $banner['savepath'].$banner['savename'];
//            p($data,1);
            $huodong->add($data);
            redirect(U('huodongList'));
        }
        $this->display();
    }

    public function huodongList(){
        $huodong    = M('huodong');

        $rs         = $huodong->select();
//        p($rs);
        $this->assign('huodongList', $rs);
        $this->display();
    }

    public function test(){
        $a = json_decode('["\u95fb","\u6c14","\u5473"]');
        $a = implode(' | ',$a);
        p($a);
    }

    public function upload(){
        pLog(I('banImg', 'img'));
        $upload             = new \Think\Upload();// 实例化上传类
        $upload->maxSize    = 3145728 ;// 设置附件上传大小
        $upload->exts       = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->savePath   = '/banner/'; // 设置附件上传目录
        //上传文件
        $info   =   $upload->uploadOne($_FILES['Filedata']);
        if(!$info) {
            // 上传错误提示错误信息
            return $upload->getError();
        }else{
            // 上传成功
            return $info;
        }
    }

}