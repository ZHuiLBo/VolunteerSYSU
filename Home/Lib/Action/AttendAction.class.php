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

        switch ($arr[face_to])
        {
        case '0':
            $arr[face_to]=东校;
            break;
        case '1':
            $arr[face_to]=南校;
            break;
        case '2':
            $arr[face_to]=全校;
            break;
        default:
            break;
        }

        $this->assign('activity',$arr);
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

    public function applyActicity(){
        $activity=M('activity');
        $application=M('application');
        $arr=$application->where("activity_id='%s' AND user_id='%s'", $_GET['activity_id'], $_SESSION['user_id'])->find();
        if ($arr){
            $this->ajaxReturn('已申请', 0);
        };

        $arr=$activity->where("activity_id='%s'", $_GET['activity_id'])->find();
        if ($arr[number_of_applicants]<$arr[recruitment_count])
        {
            $data['activity_id'] = $_GET['activity_id'];
            $data['user_id'] = $_SESSION['user_id'];
            $data['apply_time'] = date("Y-m-d H:i:s",time());
            $result = $application->add($data);
            if ($result)
                $this->ajaxReturn('已申请', 'applied', 1);
        }
    }

}
