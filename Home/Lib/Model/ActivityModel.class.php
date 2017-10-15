<?php
	class ActivityModel extends Model{

		protected $_validate=array(
			array('title','require','活动标题不能为空！',1,'',3),
			array('sponsor','require','主办单位不能为空！',1,'',3),
			array('activity_date','require','活动日期不能为空！',1,'',3),
			array('deadline','require','截至日期不能为空！',1,'',3),
			array('activity_location','require','活动地点不能为空！',1,'',3),
			array('recruitment_count','/^[1-9]\d*$/','招募人数不能为空且必须为正整数！',1,'regex',3),
			array('hours_a_day','/^(([1-9])|(1\d)|(2[0-4]))$/','服务时长必须在1至24之间',1,'regex',3),
			array('qq_number','require','QQ群号不能为空！',1,'',3),
			array('qq_number','require','QQ群号不能为空！',1,'',3),
			array('detail','require','具体描述不能为空！',1,'',3),
		);

		protected $_auto=array(
			array('publish_time', 'getCurrentTime', 3, 'callback'), // 在新增和编辑时在publish_time填入当前时间戳,还有问题
			array('publisher', 'getPublisher', 3, 'callback'), // 在新增和编辑时在publish_time填入当前时间戳,还有问题
			array('audit_result','0'), // 在新增时在audit_result字段填入0,表示待审核
			array('number_of_applicants',0), // 在新增时在number_of_applicants字段填入0,表示已报名人数为0
		);

		protected function getCurrentTime(){
			return date('Y-m-d H:i:s',time());
		}

		protected function getPublisher(){
			return $_SESSION['user_id'];
		}
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
