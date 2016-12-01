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

    public function write_apply_repair()//方法访问路径 http://localhost/web/apply_repair/write_apply_repair
    {
        return $this->view->fetch('WriteApplyrepair');
    }

    public function create_apply_repair()
    {
        $data=$this->request->param();
        if($id=db('applyrepair')->insertGetId($data)){ //添加并返回新增主键       
            return $this->view->fetch('SuccessCreateApplyrepair',['id'=>$id]);
        }
    }

    public function delete_apply_repair()
    {       
        $data=$this->request->param();
        if(db('applyrepair')->delete($data['id'])){  // 根据主键删除  // 条件删除：db('applyrepair')->where('id',1)->delete();    
            return $this->view->fetch('SuccessDeleteApplyrepair');
        }
    }

    public function select_apply_repair()
    {    
        $data=$this->request->param();
        $db_data=db('applyrepair')->find($data['id']);  // 根据主键查询（ find查询为空返回null,select返回[] ）  // 条件查询：db('applyrepair')->where('id',1)->find();   
        return $this->view->fetch('SuccessSelectApplyrepair',['data'=>$db_data]);//如果使用select ,这里应该['data'=>$db_data[0]]
    }

    public function update_apply_repair()
    {    
        $data=$this->request->param();
        $db_data=db('applyrepair')->update($data);  // data包含主键更新，没有id请使用 where('id',1)->update() 
        return $this->view->fetch('SuccessUpdateApplyrepair',['id'=>$data['id']]);
    }
     //确认维修完成
    public function confirm_apply_repair() {
        $data=$this->request->param();
        if(db('applyrepair')->where('id',$data['id'])->setField('status',6)) {//把维修单状态改为待评价
             return $this->view->fetch('SuccessDeleteApplyrepair');
        }

    }

}
