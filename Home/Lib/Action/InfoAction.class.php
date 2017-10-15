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
        $this->display();
        }
        
    //修改个人信息
    public function editInfo(){

        $data['phone_number']=$_POST['phone'];
        if($_POST['pw']!=$_POST['oldpw'])//只有当新密码不等于旧密码时，才需要更新密码
            $data['password']=$_POST['pw'];
        $data['user_id']=$_SESSION['user_id'];
        $User=D('User');//实例化User对象     
        if(!$User->create($data)){
            //如果创建失败 表示验证没通过 输出错误提示信息
            $returnData['content']=$User->getError();
        }
        else{
            //验证通过
            $saveResult=$User->save();
            if($saveResult!=false){
                $returnData['content']='修改成功!';
            }else{
                $returnData['content']='修改失败!';
            }
        }
        $this->ajaxReturn($returnData,'json');
    }

}
