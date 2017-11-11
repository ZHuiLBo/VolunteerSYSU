<?php
// 发布活动
class PublishAction extends Action {

    //查看自己发布的所有活动列表(分 待审核、审核通过、审核不通过 三种)
    public function getAllPublish(){
        $where['publisher']=$_SESSION['user_id'];
        if($_GET['selectAuditResult']!=null)
            $where['audit_result']=$_GET['selectAuditResult'];
        else
            $where['audit_result']='0';
        $ar=$where['audit_result'];
        $intAr=$where['audit_result'];
        if($ar=='0')
            $ar='待审核';
        elseif($ar=='1')
            $ar='审核通过';
        else
            $ar='审核不通过';
        $Activity=M('Activity');
        $arr=$Activity->field('activity_id, title, publish_time')->where($where)->order('publish_time desc')->select();
        $this->assign('activties',$arr);
        $this->assign('ar',$ar);
        $this->assign('intAr',$intAr);
        $this->display('./Home/Tpl/Publish/publishActiv.html');
    }

    //查看某一活动的报名情况
    public function getAllApply(){
        if($_GET['activId']==null)
            $this->error("没得到活动编号哦！");

        $where['activity_id']=$_GET['activId'];

        //得到活动标题、要招募的人数、活动日期、截止日期
        $Activity=M('Activity');
        $activ=M('Activity')->field('title, recruitment_count, activity_date, deadline')->where($where)->find();
        $this->assign('activ',$activ);

        $Application = M('Application');

        //得到已报名人数
        $apply_count=$Application->where($where)->count();
        $this->assign('apply_count',$apply_count);

        //得到已录用人数
        $where['application_state']='1';//已录用
        $hire_count=$Application->where($where)->count();
        $this->assign('hire_count',$hire_count);

        //报名截至日期之前，显示（录用/不录用 按钮）,所有报名的人；中间日期无任何按钮，只显示已录用的人；活动日期之后，显示（完成/未完成 按钮），只显示已录用的人
        $currentTime=time();
        //$currentTime=strtotime('2017-11-24');
        $sub = $currentTime - strtotime($activ['deadline']);
        $sub2 = $currentTime - strtotime($activ['activity_date']);
        if($sub<=0){//当前时间在报名截至时间之前
            $flag='0';
        }elseif($sub2<=0){//当前时间在报名截至时间之后，活动日期之间
            $flag='1';
            $where['application_state']='1';//只显示已录用的人
        }else{//当前时间在活动日期之后
            $flag='2';
            $where['application_state']='1';//只显示已录用的人
        }

        //得到学生信息，不同时间显示不同的人（所有报名的人或者已录用的人）
        $result=$Application->join('user ON user.user_id = application.user_id')->where($where)->select();
        $this->assign('results',$result);

        $this->assign('flag',$flag);
        $this->display('./Home/Tpl/Publish/checkActiv.html');
    }

    //显示新建发布页面
    public function newActiv(){
        //活动日期和截至日期不能早于当天
        $today=date("Y-m-d");
        $this->assign('today',$today);
        $this->display();
    }

    //发布，并跳转至 自己发布的活动列表页面
    public function publish(){

        // 实例化Activity模型
        $Activity = D('Activity');
        $result=$Activity->create($_POST,1);

        // 根据表单提交的POST数据创建数据对象
        if (!$result){ // 指定新增数据
             // 如果创建失败 表示验证没有通过 输出错误提示信息
             $returnData['content']=$Activity->getError();
             $returnData['goBack']=0;//表示停留在当前页面
        }else{
             // 验证通过 
             $Activity->add();
             $returnData['content']='成功创建一个活动！';
             $returnData['goBack']=1;//表示创建成功后，要跳转至 我的发布 页面
        }
        $this->ajaxReturn($returnData,'json');
        
        //$this->redirect('Publish/getAllPublish');
       
    }

    //确认录用
    public function confirmHire(){
        $Application = M('Application');
        $where['application_id'] = (int)$_GET['applicationId'];
        $result=$Application->where($where)->setField('application_state', $_GET['state']);
        $activId=$Application->where($where)->getField('activity_id');
        if($result!=false)
            $this->redirect('Publish/getAllApply', array('activId' => $activId));
        else
            $this->error("修改报名状态出错啦！");
    }

    //确认完成情况
    public function confirmDone(){
        $Application = M('Application');
        $where['application_id'] = (int)$_GET['applicationId'];
        $result=$Application->where($where)->setField('performance', $_GET['performance']);
        $activId=$Application->where($where)->getField('activity_id');
        if($result!=false)
            $this->redirect('Publish/getAllApply', array('activId' => $activId));
        else
            $this->error("修改活动完成情况出错啦！");
    }

}