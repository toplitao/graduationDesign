<?php
namespace app\Web\Controller;

use think\Request;
use think\View;
use think\Db;

class FeedBack
{
    private $view;
    private $request;
    public function __construct(){
        $this->view=new View;
        $this->request=Request::instance();
    }
    //该用户所有维修单
    public function select_apply_repair() {
        $data = ['uid' => 1];
        $list = db('applyrepair')->where($data)->select();
      
        return $this->view->fetch('SelectApplyRepair',['list'=>$list]);
       
    }
      //确认维修完成
    public function confirm_apply_repair() {
       $data=$this->request->param();
        
        if(db('applyrepair')->where('id',$data['oid'])->setField('status',6)) {//把维修单状态改为待评价
            $data = ['uid' => 1, 'status' => 6];
            $db_data = db('applyrepair')->where($data)->select();
            return $this->view->fetch('ConfirmApplyRepair',['list'=>$db_data]);
        }
    }
    //用户评价
    public function create_apply_feedback() {
        $data=$this->request->param();
        $oid = $data['oid'];
        return $this->view->fetch('CreateApplyFeedback',['oid'=>$oid]);
    }
    public function insert_apply_feedback() {
        $data=$this->request->param();
        $data['user_id'] = 1;
        if($id=db('user_feedback')->insertGetId($data)){
            if(db('applyrepair')->where('id',$data['order_id'])->setField('status',7)) {//把维修单状态改为维修完成
            
                $this->select_apply_repair();
            }
        }
    }
    public function insert_apply_repair() {
        $file = request()->file('picture');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'media' . DS . 'img');
        $date = date('Ymd',time());

        if($info){
        // 成功上传后 获取上传信息
        // 输出 jpg
        }else{
        // 上传失败获取错误信息
        echo $file->getError();
        }
        $data=$this->request->param();
        $data['picture'] = $date.'/'.$info->getFilename();
        $data['inputtime'] = date('Y-m-d',time());
       if($id=db('applyrepair')->insertGetId($data)){
            $this->select_apply_repair();
       }
    }
   
}