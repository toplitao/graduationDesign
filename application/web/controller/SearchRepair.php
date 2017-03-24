<?php
namespace app\Web\Controller;

use app\base\CommonBase;
use think\Session;

class SearchRepair extends CommonBase{

    private $userinfo;
    private $preg_phone;
    public function __construct(){
        $this->preg_phone = '/^(13|15|18|17)\d{9}$/';
        parent::__construct();
        if($this->_OnInit()) {
            $this->userinfo = $this->_OnInit();
        }
    }

    public function search_apply_repair()//方法访问路径 http://localhost/web/apply_repair/write_apply_repair
    {
        $data['code'] = 3;
        $data['userInfo'] = $this->userinfo;
        return $this->view->fetch('search_apply_repair',$data);
    }
    public function list_apply_repair(){
        if(empty($_POST)){
            return dr_show_return('300','手机号不能为空！');
        }
        if(!preg_match($this->preg_phone,$_POST['m'])){
            return dr_show_return('300','请输入有效的手机号！');
        }
        $url = '/web/search_repair/show_apply_repair';
        Session::set('moblie',$_POST['m']);
        return dr_show_return('200','操作成功',array('url'=>$url));
    }

    public function show_apply_repair(){
        $data['code'] = 3;
        $data['moblie'] = Session::get('moblie');
        $data['userInfo'] = $this->userinfo;
        $data['list'] = Db('apply_repair')->where(array('tel_number'=>$data['moblie']))->select();
        return $this->view->fetch('list_apply_repair',$data);
    }
    

    

}
