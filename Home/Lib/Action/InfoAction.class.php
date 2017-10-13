<?php
// 个人信息管理
class InfoAction extends Action {

    //显示个人信息
    public function showInfo(){
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