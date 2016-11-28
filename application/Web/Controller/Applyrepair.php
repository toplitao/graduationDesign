<?php
namespace app\Web\Controller;

use think\Request;
use think\View;
use think\Db;

class ApplyRepair
{
    private $view;
    private $request;
    public function __construct(){
        $this->view=new View;
        $this->request=Request::instance();
    }

    public function write_applyrepair()//方法访问路径 http://localhost/web/applyrepair/write_applyrepair
    {
        return $this->view->fetch('WriteApplyrepair');
    }

    public function create_applyrepair()
    {
        $data=$this->request->param();
        if($id=db('applyrepair')->insertGetId($data)){ //添加并返回新增主键       
            return $this->view->fetch('SuccessCreateApplyrepair',['id'=>$id]);
        }
    }

    public function delete_applyrepair()
    {       
        $data=$this->request->param();
        if(db('applyrepair')->delete($data['id'])){  // 根据主键删除  // 条件删除：db('applyrepair')->where('id',1)->delete();    
            return $this->view->fetch('SuccessDeleteApplyrepair');
        }
    }

    public function select_applyrepair()
    {    
        $data=$this->request->param();
        $db_data=db('applyrepair')->find($data['id']);  // 根据主键查询（ find查询为空返回null,select返回[] ）  // 条件查询：db('applyrepair')->where('id',1)->find();   
        return $this->view->fetch('SuccessSelectApplyrepair',['data'=>$db_data]);//如果使用select ,这里应该['data'=>$db_data[0]]
    }

    public function update_applyrepair()
    {    
        $data=$this->request->param();
        $db_data=db('applyrepair')->update($data);  // data包含主键更新，没有id请使用 where('id',1)->update() 
        return $this->view->fetch('SuccessUpdateApplyrepair',['id'=>$data['id']]);
    }

}
