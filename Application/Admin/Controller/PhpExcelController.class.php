<?php

namespace Admin\Controller;

use Think\Controller;

class PhpExcelController extends Controller
{
    public function getObj(){
        Vendor('Excel.PHPExcel');
        return $objPHPExcel   = new \PHPExcel();
    }
}