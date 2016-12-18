<?php
namespace app\Web\Controller;

use think\Request;
use think\View;
use think\Db;
use app\BaseController\CommonBase;

class ApplyRepair extends CommonBase
{
    public function write_apply_repair()//方法访问路径 http://localhost/web/apply_repair/write_apply_repair
    {
        return $this->view->fetch('WriteApplyrepair');
    }

    public function insert_apply_repair() {
        $file = request()->file('picture');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public/media/img');
        $date = date('Ymd',time());

        if($info){
        // 成功上传后 获取上传信息
        // 输出 jpg
        }else{
        // 上传失败获取错误信息
        echo $file->getError();
        }
        $data=$this->request->param();
        $data['uid']=$this->user['id'];
        $data['picture'] = $date.'/'.$info->getFilename();
        $data['inputtime'] = date('Y-m-d',time());
       if($id=db('applyrepair')->insertGetId($data)){
            $list = db('applyrepair')->where(['uid'=>$this->user['id']])->select();
            return $this->view->fetch('Web@feed_back/SelectApplyRepair',['list'=>$list]);
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

}
