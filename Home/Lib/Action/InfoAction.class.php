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
		//获取用户的id
		$id=$_SESSION['user_id'];
		//获得用户修改后的值
		$phone=$_POST['phone'];
		$pw=$_POST['pw'];
		//修改数据库
		$User=M('User');//实例化User对象
		//要修改的数据对象属性赋值
		$data['phone_number']=$phone;
		$data['password']=$pw;
		$where['user_id']=$id;
		$result = $User->where($where)->save($data);//根据条件保存修改的数据

		if($result){
			//$returnData['status']='true';
			$returnData['content']='修改成功!';
		}else{
			//$returnData['status']='false';
			$returnData['content']='修改失败!';
		}
		$this->ajaxReturn($returnData,'json');	
	}

}