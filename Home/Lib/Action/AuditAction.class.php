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
        $this->display();
    }
    //审核
    public function audit(){
        $this->display();
    }
}