<?php
namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller
{

    function _initialize()
    {
        if(session('loginId') == NULL){
            $this->redirect('Login/index');
        }
    }

    public function welcome()
    {
        $this->display();
    }

    public function index()
    {
        $this->display();
    }

    public function getUserInfo(){
        $user   = M('user');
        $res    = $user->where('user_id <99')->select();
//        p($res);
        p($this->dataExport($res));
    }

    public function dataExport($data)
    {

//        p($objPHPExcel);
        return $objPHPExcel->createSheet($data);
//        p($objExcel);
//        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
//
//        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
//        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));
//        for($i=0;$i<$cellNum;$i++){
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]);
//        }
//        // Miscellaneous glyphs, UTF-8
//        for($i=0;$i<$dataNum;$i++){
//            for($j=0;$j<$cellNum;$j++){
//                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
//            }
//        }
//
//        header('pragma:public');
//        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
//        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
//        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//        $objWriter->save('php://output');
//        exit;
    }
    /**
     *
     * 导出Excel
     */
    function expUser(){//导出Excel
        $xlsName  = "User";
        $xlsCell  = array(
            array('id','账号序列'),
            array('truename','名字'),
            array('sex','性别'),
            array('res_id','院系'),
            array('sp_id','专业'),
            array('class','班级'),
            array('year','毕业时间'),
            array('city','所在地'),
            array('company','单位'),
            array('zhicheng','职称'),
            array('zhiwu','职务'),
            array('jibie','级别'),
            array('tel','电话'),
            array('qq','qq'),
            array('email','邮箱'),
            array('honor','荣誉'),
            array('remark','备注')
        );
        $xlsModel = M('Member');

        $xlsData  = $xlsModel->Field('id,truename,sex,res_id,sp_id,class,year,city,company,zhicheng,zhiwu,jibie,tel,qq,email,honor,remark')->select();
        foreach ($xlsData as $k => $v)
        {
            $xlsData[$k]['sex']=$v['sex']==1?'男':'女';
        }
        $this->exportExcel($xlsName,$xlsCell,$xlsData);
    }


}