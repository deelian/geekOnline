<?php 
namespace Admin\Controller;

use Think\Controller;
use Admin\Controller\PhpExcelController as PHPExcel;


/**
* 数据导出操作
*/
class DataexportController extends PHPExcel
{
	
	function __initlilize()
	{

	}

	public function export($value='')
	{
		$objPHPExcel	= $this->getObj();
		p($objPHPExcel);
	}
}

 ?>