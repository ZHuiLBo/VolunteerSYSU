<?php
// 管理员审核
class AuditAction extends Action {

    //主页，显示已审核，未审核，审核不通过的活动列表 
    public function auditList(){
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
        if($intAr=='0')
            $arr=$Activity->field('activity_id, title, publish_time, sponsor')->where($where)->order('publish_time asc')->select();
        else
            $arr=$Activity->field('activity_id, title, publish_time, sponsor')->where($where)->order('publish_time desc')->select();
        $this->assign('activties',$arr);
        $this->assign('ar',$ar);
        $this->assign('intAr',$intAr);
        $this->display();
    }

    //显示具体活动审核页
    public function auditActiv(){
        if($_GET['activId']==null)
            $this->error("没有取到活动编号哦！");
        
        $where['activity_id']=$_GET['activId'];
        $Activity=M('Activity');
        $activ=$Activity->where($where)->find();
        $ar=$activ['audit_result'];
        if($ar=='0')
            $ar='待审核!';
        elseif($ar=='1')
            $ar='审核通过!';
        else
            $ar='审核不通过!';
        $this->assign('activ',$activ);
        $this->assign('ar',$ar);
        $this->display();
    }

    //审核
    public function audit(){
        if($_POST['activity_id']==null || $_POST['pass']==null)
            $this->error("没有取到活动编号和审核结果哦");
        $where['activity_id']=$_POST['activity_id'];
        $data['audit_result']=$_POST['pass'];
        $data['publish_time']=date('Y-m-d H:i:s',time());
        $data['audit_opinion']=$_POST['opinion'];
        
        $Activity=M('Activity');
        $result=$Activity->where($where)->save($data);
        if($result!=false)
            $this->redirect('Audit/auditList');
        else
            $this->error("保存审核情况出错啦！");

    }
}