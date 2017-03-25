<?php
namespace app\Web\Controller;

use app\base\CommonBase;
use think\Session;
use think\Config;
class ApplyRepair extends CommonBase
{
    private $userinfo;
    public function __construct(){
        parent::__construct();
        if($this->_OnInit()) {
            $this->userinfo = $this->_OnInit();
        }
    }

    //方法访问路径 http://localhost/web/apply_repair/write_apply_repair
    public function write_apply_repair(){
        if(!Session::get('userinfo')){
            return $this->view->fetch('index@index/login');
        }
        return $this->view->fetch('write_apply_repair',['code'=>2,'userInfo'=>$this->userinfo]);
    }

    public function insert_apply_repair() {
        //	获取表单上传文件
        $file = request()->file('picture');
        define("UPLOAD_ROOT", 'http://location/media/img/');
        if (!file_exists (UPLOAD_ROOT)) {
            mkdir ( UPLOAD_ROOT, 0777, true );
        }
        $info = $file->move(UPLOAD_ROOT);
        if($info){
            $data=$this->request->param();
            $data['uid']=$this->userinfo['id'];
            $domain_name = Config::get('DOMAIN_NAME');
            $data['picture'] = $domain_name .'/media/img/'.$info->getSaveName();
            $data['created_at'] = date('Y-m-d',time());
            if($id=db('apply_repair')->insertGetId($data)){
//                $list = db('apply_repair')->where(['uid'=>$this->userinfo['id']])->select();
//                return $this->view->fetch('web@search_repair/list_apply_repair',['list'=>$list,'code'=>2]);
//                  header('location:'.$_SERVER['HTTP_ORIGIN'].'/web/search_repair/search_apply_repair');
                  echo "<script>window.location.href = '/web/search_repair/search_apply_repair'</script>";
            }
        }else {
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }
    
    public function delete_apply_repair()
    {       
        $data=$this->request->param();
        if(db('applyrepair')->delete($data['id'])){  // 根据主键删除  // 条件删除：db('applyrepair')->where('id',1)->delete();    
            return $this->view->fetch('success_delete_apply_repair');
        }
    }

    public function select_apply_repair()
    {    
        $data=$this->request->param();
        $db_data=db('applyrepair')->find($data['id']);  // 根据主键查询（ find查询为空返回null,select返回[] ）  // 条件查询：db('applyrepair')->where('id',1)->find();   
        return $this->view->fetch('success_select_apply_repair',['data'=>$db_data]);//如果使用select ,这里应该['data'=>$db_data[0]]
    }

    public function update_apply_repair()
    {    
        $data=$this->request->param();
        $db_data=db('applyrepair')->update($data);  // data包含主键更新，没有id请使用 where('id',1)->update() 
        return $this->view->fetch('success_update_apply_repair',['id'=>$data['id']]);
    }

}
