<?php
// 登录,退出
class LoginAction extends Action {

    //显示登录页面
    public function login(){
        $this->display();
    }

    //登录
    public function doLogin(){

        //接受值
        $username=$_POST['username'];
        $password=md5($_POST['password']);

        //判断用户在数据库中是否存在
        $user=M('User');
        $where['username']=$username;
        $where['password']=$password;
        $arr=$user->field('user_id, role, name')->where($where)->find();
      
        if($arr){
            //存在 允许登录 
            $_SESSION['username']=$username;
            $_SESSION['name']=$arr['name'];
            $_SESSION['user_id']=$arr['user_id'];
            $_SESSION['role']=$arr['role'];
        
            //$this->success('用户登录成功', U('Index/index'));
            $this->redirect('Index/index');

            }
        else{
            //不存在 显示错误信息
            $this->error('该用户不存在');
            }
        }
    
        //退出
        public function doLogout(){
            $_SESSION=array();
                if(isset($_COOKIE[session_name()])){
                    setcookie(session_name(),'',time()-1,'/');
                }
            session_destroy();
            $this->redirect('Index/index');
        }
    }
