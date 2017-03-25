<?php
namespace app\Admin\Controller;

use think\Request;
use think\View;
use think\Db;
use app\base\CommonBase;
use think\Session;

class Index extends CommonBase
{
    protected $view;
    protected $request;
    private $user;
    public function __construct(){
        $this->view=new View;
        $this->request=Request::instance();
        if(!$this->_OnInit()){
//            header('location:/index/index/login');
        }else{
            $this->user = $this->_OnInit();
        }
    }
    
    public function index()//方法访问路径 http://localhost/web/apply_repair/write_apply_repair
    {
        $data['userinfo'] = $this->user;
        return $this->view->fetch('index',$data);
    }

    /**
     * 退出操作
     */
    public function loginout(){
        Session::clear();
        return $this->view->fetch('index@index/login');
    }
    //维修单管理
    public function repair_order() {
        $data=$this->request->param();
        if(!empty($data['status'])) {
            $status = $data['status'];
        }else{
            $status = 3;//未处理维修单
        }
        $uid = $this->user['id'];
        $list = db('apply_repair')->where(['status'=>$status])->where(['user_id'=>$uid])->paginate(10);
        return $this->view->fetch('repair_order',['list'=>$list]);
        
    }
    //发货
    public function send_goods() {
        $uid = $this->user['id'];
        $data=$this->request->param();
        $time = date("Y-m-d",time());
        if(!empty($data['back_number'])) {
            db('apply_repair')->where('id',$data['id'])->update(['back_number' => $data['back_number'],'status'=>6,'updated_at'=>$time,'express_code'=> $data['express']]);
            $insert = ['oid' => $data['id'],'status'=> 6,'charger' => $this->user['username'],'created_at' => $time,'updated_at'=>$time,'uid' => $this->user['id']];
             db('documentary')->insert($insert);//插入跟单信息
            echo "<script>alert('操作成功');</script>";
            $list = db('apply_repair')->where(['status'=>6])->where(['user_id'=>$uid])->paginate(10);
            return $this->view->fetch('repair_order',['list'=>$list]);
        }else{
            echo "<script>alert('操作失败');</script>";
        }
    }
    //维修完成
    public function finish_repair() {
        $data=$this->request->param();
        $time = date("Y-m-d",time());
        db('apply_repair')->where('id',$data['aid'])->update(['status' => 5,'updated_at'=>$time]);
        $insert = ['oid' => $data['aid'],'status'=> 6, 'charger' => $this->user['username'],'created_at' => $time,'updated_at'=>$time,'uid' => $this->user['id']];
        db('documentary')->insert($insert);//插入跟单信息
        $uid = $this->user['id'];
        $list = db('apply_repair')->where(['status'=>5])->where(['user_id'=>$uid])->paginate(10);
        return $this->view->fetch('repair_order',['list'=>$list]);
    }
    //配件
    public function fittings_list() {
        $data=$this->request->param();
        $list = db('fittings')->paginate(5);
        if(!empty($data['aid'])) {
            $aid = $data['aid'];
            return $this->view->fetch('fittings_list',array('list'=>$list,'aid'=> $aid));
        }else{
            $aid = 0;
            return $this->view->fetch('fittings_list',array('list'=>$list,'aid'=> $aid));
        }
        
    }
    //确认维修
    public function confirm_repair() {
         $data=$this->request->param();
         $fittings = substr($data['fittings'],1);
         $fittings_arr = explode(':',$fittings);
         $time = date("Y-m-d",time());
         for($i=0;$i<count($fittings_arr);$i++) {
             $fittings_data = explode(',',$fittings_arr[$i]);
             $result = db('fittings')->where('id',$fittings_data[0])->find();//搜索原数据
             $number = $result['number'] - $fittings_data[1];
             //修改配件库存数量
             db('fittings')->where('id',$fittings_data[0])->update(['number' => $number,'updated_at'=>$time]);
             //插入跟单信息
             $inserts = ['oid' => $data['aid'],'status'=> 6, 'charger' => $this->user['username'],'created_at' => $time,'updated_at'=>$time,'uid' => $this->user['id']];
             db('documentary')->insert($inserts);
             //配件出库记录
             $insert = ['oid' => $data['aid'], 'fid' => $fittings_data[0],'created_at' => $time,'updated_at'=>$time,'number' => $fittings_data[1]];
             db('fitting_log')->insert($insert);
         }
         if(db('apply_repair')->where('id',$data['aid'])->update(['status' => 4])) {
            echo json_encode(array('status'=> 1,'msg'=>'接单成功'));
         }else{
             echo json_encode(array('status'=> 2,'msg'=>'接单失败'));
         }
    }
}
