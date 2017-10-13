<?php
// 个人信息管理
class InfoAction extends Action {

    //显示个人信息
    public function showInfo(){
			//从session得到用户id
			$where['user_id']=$_SESSION['user_id'];
			//从数据库取出对应user_id用户的所有信息
			$user=M('User');
			$arr=$user->where($where)->find();
			//转化 校区对应的值
			if($arr['campus']=='0')
				$arr['campus']="东校区";
			else 
				$arr['campus']="南校区";
			//将取出的数据赋值给页面
			$this->assign('info',$arr);
			//显示对应页面
		  $this->display();
    }

    //查看时长
    public function showTime(){
			$this->display();
		}
		
		//修改个人信息
		public function editInfo(){
			$this->redirect('Info/showInfo');
		}

}