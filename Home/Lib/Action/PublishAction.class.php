<?php
// 发布活动
class PublishAction extends Action {

	//查看自己发布的所有活动列表
    public function getAllPublish(){
		$this->display('./Home/Tpl/Publish/publishActiv.html');
    }

    //查看某一活动的报名情况
    public function getAllApply(){
		$this->display('./Home/Tpl/Publish/checkactiv.html');
    }

    //显示新建发布页面
    public function newActiv(){
        $this->display();
    }

    //发布，并跳转至 自己发布的活动列表页面
    public function publish(){
        $this->redirect('Publish/getAllPublish');
    }

    //确认录用
    public function confirmHire(){
        $this->redirect('Publish/getAllApply');
    }

    //确认完成情况
    public function confirmDone(){
        $this->redirect('Publish/getAllApply');
    }

}