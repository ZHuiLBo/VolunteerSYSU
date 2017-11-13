<?php
// 个人信息管理
class InfoAction extends Action {

    //显示个人信息
    public function showInfo(){
        //从session得到用户id
        $where['user_id']=$_SESSION['user_id'];
        //从数据库取出对应user_id用户的所有信息
        $user=M('User');
        $arr=$user->where($where)->find();
        //转化 校区对应的值
        if($arr['campus']=='0')
            $arr['campus']="东校区";
        else 
            $arr['campus']="南校区";
        //将取出的数据赋值给页面
        $this->assign('info',$arr);
        //显示对应页面
        $this->display();
    }

    //查看时长
    public function showTime(){

        $startDate=$_GET['start'];
        $endDate=$_GET['end'];
        if($startDate==null || $endDate==null){
            $this->assign('flag',0);
            $this->display();
        }else{
            $this->assign('startTime',$startDate);
            $this->assign('endTime',$endDate);
            $this->assign('flag',1);
    
            //得到学生信息
            $where['user_id']=$_SESSION['user_id'];
            $user=M('User');
            $arr=$user->field('academy, name, username')->where($where)->find();
            $this->assign('info',$arr);
    
            //这部分未测试
            //得到该学生某段时间的服务时长
            $where['performance']=1;//已完成
            $where['activity_date'] = array(array('EGT',$startDate),array('ELT',$endDate),'AND');
            $Application=M('Application');
            $result=$Application->join('activity ON activity.activity_id = application.activity_id')->where($where)->field('title, activity_date, hours_a_day')->order('activity_date, desc')->select();
            $this->assign('results',$result);
            $this->display();
        }
    }
  
    //修改个人信息
    public function editInfo(){
        if($_POST['phone']!=null){
            $data['phone_number']=$_POST['phone'];
            $returnData['content']='联系电话';
        }
        if($_POST['pw']!=null){
            $data['password']=$_POST['pw'];
            $returnData['content']='密码';
        }

        $data['user_id']=$_SESSION['user_id'];
        $User=D('User');//实例化User对象
        if(!$User->create($data)){
            //如果创建失败 表示验证没通过 输出错误提示信息
            $returnData['content']=$User->getError();
            $returnData['flag']='fail';
        }else{
            //验证通过
            $saveResult=$User->save();
            if($saveResult!=false){
                $returnData['content']=$returnData['content'].'修改成功!';
            }else{
                $returnData['content']=$returnData['content'].'修改失败!';
            }
            $returnData['flag']='success';
        }
        $this->ajaxReturn($returnData,'json');
    }

}
