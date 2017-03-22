<?php 
namespace app\Admin\Controller;

use think\Request;
use think\View;
use think\Db;

Class FittingsAdmin {
    public function __construct(){
        $this->view=new View;
        $this->request=Request::instance();
		define("URL_FITTINGS", '/index.php/admin/fittings_admin/FittingsIndex');
    }
    /**
	 * 配件管理功能首页
	 */
    public function FittingsIndex(){
    	$data = db("fittings")->select();
        return $this->view->fetch('fittings_index',['data'=>$data]);
    }
	/**
	 * 配件编辑操作
	 */
	public function FittingsEdit(){
		if($this->request->param()){
			$param = $this->request->param();
			$count = count($param);
			if($count == 1){
				$id = $param['id'];
				$data = db("fittings")->where('id',$id)->find();
				return $this->view->fetch('fittings_edit',['data' => $data]);
			}
			if($count > 1){
				if(!is_numeric($param['number']) || !is_numeric($param['id'])){
					return dr_show_return(2,'参数非法！');
				}
				$res = db("fittings")->where('id',$param['id'])->update(['number' => $param['number']]);
				if($res){
					return dr_show_return(1,'编辑成功！',URL_FITTINGS);
				}else{
					return dr_show_return(2,'编辑失败！');
				}
			}
		}	
	} 
	/**
	 * 配件删除操作
	 */
	public function FittingsDel(){
		$post = $this->request->param();
		if(!is_numeric($post['id'])){
			return dr_show_return(2, '参数非法！');
		}
		$res = db('fittings')->where('id',$post['id'])->delete();
		if($res){
				return dr_show_return(1,'删除成功！',URL_FITTINGS);
		}else{
				return dr_show_return(2,'删除失败！');
		}
	} 
	/**
	 * 配件增加操作
	 */
	public function FittingsAdd(){
		if($this->request->param()){
			$post = $this->request->param();
			if(!is_numeric($post['number'])){
				return dr_show_return(2,'参数非法！');
			}
			if(empty($post['fittingsName']) || empty($post['number'])){
				return dr_show_return(2,'参数不能为空！');
			}
			$res = db("fittings")->insertGetId($post);
			if($res){
				return dr_show_return(1,'新增成功！',URL_FITTINGS);
			}else{
				return dr_show_return(2,'新增失败！');
			}
		}else{
			return $this->view->fetch('FittingsAdd');
		}
	} 
}
?>