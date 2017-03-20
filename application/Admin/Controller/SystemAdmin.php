<?php
namespace app\Admin\Controller;

use think\Request;
use think\View;
use think\Db;
use think\Session;
use app\BaseController\CommonBase;

class SystemAdmin extends CommonBase
{
    //后台首页
    public function admin_index() {
        
        $list = db('applyrepair')->where(['status'=>0])->paginate(5);
        return $this->view->fetch('SystemIndex',['list'=>$list]);
       
    }
    public function rest_password(){
         $reset_content=$this->request->param();
         $user_info=db('user')->where('id',$this->user['id'])->find();
         if($user_info['password']==md5($reset_content['ori_password'])){
             if($reset_content['new_password']==$reset_content['once_password']){
                db('user')->where('id',$this->user('id'))->update(array('password'=>md5($reset_content['new_password'])));
                return $msg='密码修改成功！';
             }else{
                 return $msg='两次密码不一致！';
             }
              
         }else{
             return $msg='密码错误！';
         }
    }
}