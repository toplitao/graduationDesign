<?php
namespace app\Web\Controller;

use think\Request;
use think\View;
use think\Db;
use app\base\CommonBase;

class SearchRepair extends CommonBase
{
    protected $view;
    protected $request;
    public function __construct(){
        $this->view=new View;
        $this->request=Request::instance();
        if(!$this->_OnInit()){
//            header('location:/index/index/login');
        }else{
            $this->user = $this->_OnInit();
        }
    }

    public function search_apply_repair()//方法访问路径 http://localhost/web/apply_repair/write_apply_repair
    {
        $data['code'] = 3;
        $data['userInfo'] = $this->user;
        return $this->view->fetch('search_apply_repair',$data);
    }
    public function list_apply_repair() {
        return $this->view->fetch('list_apply_repair');
    }
    

    

}
