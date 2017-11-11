<?php
// 参加活动
class AttendAction extends Action {

    //查看所有活动列表
    public function getAllActiv(){
        $this->display();
    }

    //查看活动详情
    public function getActivInfo(){
        $activity=M('activity');
        $arr=$activity->where("activity_id='%s'", $_GET['activity_id'])->find();

        $arr[face_to]=$this->face_toTran($arr[face_to]);

        $apply_state=$this->checkApply($_GET['activity_id']);
        $apply_date=$this->checkTime($arr['deadline']);
        $apply_number=$this->checkNumber($arr['recruitment_count'], $arr['number_of_applicants']);

        $this->assign('activity',$arr);
        $this->assign('apply_date', $apply_date);
        $this->assign('apply_state', $apply_state);
        $this->assign('apply_number', $apply_number);
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

    //Ajax 活动列表
    public function ajaxAllActiv(){
        $activity=M('activity');
        $arr=$activity->where("audit_result='%s'", 1)->field('title, recruitment_count, activity_date, deadline, face_to, activity_id')->order('deadline')->select();
        $this->ajaxReturn($arr);
    }

    //报名
    public function applyActivity(){
        $activity=M('activity');
        $application=M('application');
        // $arr=$application->where("activity_id='%s' AND user_id='%s'", $_GET['activity_id'], $_SESSION['user_id'])->find();

        $arr=$activity->where("activity_id='%s'", $_GET['activity_id'])->find();
        if ($arr[number_of_applicants] < $arr[recruitment_count])
        {
            //修改活动已申请人数
            $arr[number_of_applicants] = $arr[number_of_applicants] + 1;
            $activity->where("activity_id='%s'", $_GET['activity_id'])->save($arr);
            //增加申请记录
            $data['activity_id'] = $_GET['activity_id'];
            $data['user_id'] = $_SESSION['user_id'];
            $data['apply_time'] = date("Y-m-d H:i:s",time());
            $result = $application->add($data);
            if ($result){
                $this->ajaxReturn();
            }
        }
    }

    //取消报名
    public function unapplyActivity(){
        $activity=M('activity');
        $application=M('application');

        $res = $application->where("activity_id='%s' AND user_id='%s'", $_GET['activity_id'], $_SESSION['user_id'])->delete();
        if ($res > 0 and $res != false)
        {
            $arr=$activity->where("activity_id='%s'", $_GET['activity_id'])->find();
            $arr[number_of_applicants] = $arr[number_of_applicants] - $res;
            $activity->where("activity_id='%s'", $_GET['activity_id'])->save($arr);
        }
        $this->ajaxReturn();
    }


    //改变face_to值
    function face_toTran($face_to){
        switch ($face_to)
        {
        case '0':
            return '东校';
        case '1':
            return '南校';
        case '2':
            return '全校';
        }
    }

    //检查是否已经申请
    function checkApply($activity_id){
        $application=M('application');
        $arr=$application->where("activity_id='%s' AND user_id='%s'", $activity_id, $_SESSION['user_id'])->find();
        if ($arr){
            return 1;
        }
        else{
            return 0;
        }
    }

    //检查是否过期
    function checkTime($expect_date){
        $now_time = time();
        $expect_time = strtotime('+1 day', strtotime($expect_date));
        if ($expect_time > $now_time){
            return 0;
        }
        else {
            return 1;
        }
    }

    //报名人数
    function checkNumber($all, $now){
        if ($all > $now)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

}
