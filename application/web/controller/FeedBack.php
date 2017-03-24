<?php
namespace app\Web\Controller;

use app\base\CommonBase;

class FeedBack extends CommonBase{

    private $userinfo;
    public function __construct(){
        parent::__construct();
        if($this->_OnInit()) {
            $this->userinfo = $this->_OnInit();
        }
    }
    //该用户所有维修单
    public function select_apply_repair() {
        $list = db('applyrepair')->where(['uid'=>$this->user['id']])->select();
        return $this->view->fetch('select_apply_repair',['list'=>$list]);
       
    }
      //确认维修完成
    public function confirm_apply_repair() {
       $data=$this->request->param();
        
        if(db('applyrepair')->where('id',$data['oid'])->setField('status',6)) {//把维修单状态改为待评价
            $data = ['uid' => 1, 'status' => 6];
            $db_data = db('applyrepair')->where($data)->select();
            return $this->view->fetch('confirm_apply_repair',['list'=>$db_data]);
        }
    }
    //用户评价
    public function create_apply_feedback() {
        $data=$this->request->param();
//        $oid = $data['oid'];
//        return $this->view->fetch('create_apply_feedback',['oid'=>$oid]);
        $data['code'] = 3;
        return $this->view->fetch('create_apply_feedback',$data);
    }
    public function insert_apply_feedback() {
        $data=$this->request->param();
        $data['user_id'] = $this->userinfo['id'];
        if($id=db('user_feedback')->insertGetId($data)){
            if(db('applyrepair')->where('id',$data['order_id'])->setField('status',7)) {//把维修单状态改为维修完成
//                $this->select_apply_repair();
                return dr_show_return('200','操作成功',array('url'=>'/web/search_repair/search_apply_repair'));
            }
        }
        return dr_show_return('300','操作失败');
    }
   
}