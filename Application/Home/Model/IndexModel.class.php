<?php 
namespace Home\Model;
use Think\Model;
class UserModel extends Model{    
//调用配置文件中的数据库配置1    
	protected $connection = 'DB_OLD';
}
 ?>