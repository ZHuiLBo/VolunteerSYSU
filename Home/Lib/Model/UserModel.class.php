<?php
	class UserModel extends Model{

		protected $_validate=array(
			array('phone_number','/^1[3|4|5|8][0-9]\d{4,8}$/','手机号码错误！',0,'regex',3),
			array('password','require','密码不能为空！',0,'',3),
			array('password','/^.{8,}$/','密码不能少于8位！',0,'regex',3),
		);

		protected $_auto=array(
			array('password','md5',3,'function'),//在新增或者更新时进行md5加密 
		);

		/*
		protected function checkCode($code){
			if(md5($code)!=$_SESSION['code']){
				return false;
			}else{
				return true;
			}
		}*/
	}
?>
