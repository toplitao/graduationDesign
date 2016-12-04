<?php 
namespace app\Admin\Controller;

use think\Request;
use think\View;
use think\Db;

Class FittingsAdmin {
    public function __construct(){
        $this->view=new View;
        $this->request=Request::instance();
    }
    /**
	 * 配件管理功能首页
	 */
    public function FittingsIndex(){
    	$data = db("fittings")->select();
        return $this->view->fetch('FittingsIndex',['data'=>$data]);
    }
	/**
	 * 配件删除操作
	 */
	public function FittingsDel(){
		$param = $this->request->param();
		$res = db('fittings')->where('id',$param['id'])->delete();
		$url = '/index.php/Admin/Fittings_admin/FittingsIndex';
		if($res){
			echo "<script>alert('删除成功');";
			echo "window.location=".$url;
			echo "</script>";
		}else{
			echo "<script>alert('删除失败');";
			echo "window.location=".$url;
			echo "</script>";
		}
	} 
	/**
	 * 配件增加操作
	 */
	public function FittingsAdd(){
		if($this->request->param()){
			print_r(3);
		}else{
			return $this->view->fetch('FittingsAdd');
		}
	} 
}
?>