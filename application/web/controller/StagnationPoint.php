<?php
/**
 * Created by PhpStorm.
 * User: ssl
 * Date: 2017/3/23
 * Time: 21:35
 */
namespace app\Web\Controller;

use app\base\CommonBase;

class StagnationPoint extends CommonBase{

    private $userinfo;
    public function __construct(){
        parent::__construct();
        if($this->_OnInit()) {
            $this->userinfo = $this->_OnInit();
        }
    }

    public function index() {
        $data['code'] = 5;
        $data['userInfo'] = $this->userinfo;
        $data['list'] = db('station')->paginate(10);
        return $this->view->fetch('index',$data);
    }
    public function description() {
        $result=$this->request->param();
        $data['code'] = 5;
        $data['userInfo'] = $this->userinfo;
        if(!empty($result)) {
            $data['list'] = db('station')->where(['id'=>$result['sid']])->select();
            foreach($data['list'] as $key => $val){
                $data['list'][$key]['data'] = json_decode($data['list'][$key]['work_img'],true);
            }
        }
        $data['user_list'] = db('user')->where(array('sid'=>$result['sid']))->select();
        return $this->view->fetch('description',$data);

    }

}
