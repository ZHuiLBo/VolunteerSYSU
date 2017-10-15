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
        $this->display('./Home/Tpl/Publish/checkactiv.html');
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
        $this->redirect('Publish/getAllApply');
    }

    //确认完成情况
    public function confirmDone(){
        $this->redirect('Publish/getAllApply');
    }

}