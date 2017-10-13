<?php
// 参加活动
class AttendAction extends Action {

	//查看所有活动列表
    public function getAllActiv(){
		$this->display();
    }

    //查看活动详情
    public function getActivInfo(){
		$this->display('./Home/Tpl/Attend/activInfo.html');
    }

    //申请报名
    public function applyActiv(){
        $this->redirect('Attend/showApply');
    }

    //查看已报名列表
    public function showApply(){
        $this->display('./Home/Tpl/Attend/involvement.html');
    }

}