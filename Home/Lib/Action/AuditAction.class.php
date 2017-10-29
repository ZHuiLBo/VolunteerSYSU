<?php
// 本类由系统自动生成，仅供测试用途
class AuditAction extends Action {
    //主页，显示已审核，未审核，审核不通过的活动列表 
    public function index(){
        $this->display('./Home/Tpl/Audit/auditList.html');
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