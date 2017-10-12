<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
			//通过session判断用户是否登录过
			if(isset($_SESSION['username']) && $_SESSION['username']!=''){
				
				//登录过 根据不同的role进入不同页面
				if($_SESSION['role']=='0')
					$this->redirect('Attend/getAllActiv');
				else
					$this->redirect('Audit/index');

			}else{
				$this->redirect('Login/login');
			}
    }
}