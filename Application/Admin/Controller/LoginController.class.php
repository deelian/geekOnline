<?php 
namespace Admin\Controller;

use Think\Controller;
use Admin\Controller\VerifyController;

/**
* 登录注册控制器
*/
class LoginController extends Controller
{

	public function index()
	{
		if(session('loginId') != NULL){
			$this->redirect('Index/index');
		}else{
			$info = array(
				'copyright' => C('SYS_COPYRIGHT'),
				'powered'	=> C('SYS_POWEREDBY')
			);
			$this->assign('info', $info);
			$this->display('login');
		}
	}

	public function loginCheck()
	{

		if (IS_AJAX) {
//			 $this->ajaxReturn(I());
			// echo "string";
			$verify = A('Verify');
			if($verify->checkVerify(I('subData')['verify'])){
				$admin 		= M('admin');
				$res 		= $admin->where(['account'=>I('subData')['account']])->find();
				pLog($res, I('subData')['account']);
				if($res['passwd'] == md5(I('subData')['passwd'])){
					session('loginId', $res['id']);
					jRet([
						'code'	=> '200',
						'msg'	=> '验证通过！正在进入系统……',
						'url'	=> U('Index/index')
					]);
				}else{
					jRet([
						'code'	=> '502',
						'msg'	=> '账号或密码错误！请重试……',
						'url'	=> U('Login/index')
					]);
				}
			}else{
				jRet([
					'code'	=> '501',
					'msg'	=> '验证码输入有误！我给你换一张吧'
				]);
			}

		} else {
			$this->display();
		}
	}

	public function loginOut(){
		session('loginId', null);
		$this->redirect(U('Login/index'));
	}

	public function setAccount(){
		$Account 	= M('admin');
		$subData 	= [
			'account'=>'deelian',
			'passWd'=>md5('deelian')
		];
		$rs = $Account->add($subData);
		if($rs){
			p($Account->getLastSql());
		}
	}

}

?>