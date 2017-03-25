<?php
namespace app\Web\Controller;

use app\base\CommonBase;
use think\Session;
use think\config;
use think\Db;
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
        if(!empty(Session::get('moblie'))) {
             $data['moblie'] = Session::get('moblie');
        }else{
             $data['moblie'] = 0;
        }
        $data['userInfo'] = $this->userinfo;
        $data['status'] = 0;
        $status = $this->request->param('status');
        if(!empty($data['moblie'])) {
            if($status){
                $data['status'] = $this->request->param('status');
                $data['list'] = Db('apply_repair')->where('tel_number',$data['moblie'])->where('status',$status)->select();
            }else{
                
                $data['list'] = Db('apply_repair')->where(array('tel_number'=>$data['moblie']))->select();
            }
        }else{
            if($status){
                $data['status'] = $this->request->param('status');
                $data['list'] = Db('apply_repair')->where('uid',$this->userinfo['id'])->where('status',$status)->select();
            }else{
               
                $data['list'] = Db('apply_repair')->where(['uid' => $this->userinfo['id']])->select();
                
            }
        }
        $statusList = Config::get('status');
        $arrayList = array();
        foreach($statusList as $key => $val){
            $rs = Db::query('select * from apply_repair where `status` = '.$key.' and `tel_number` = '.$data['moblie']);
            $count = count($rs);
            $arrayList[$key] = array('status'=>$key,'count'=>$count);
        }
        $data['arrayList'] = $arrayList;
        return $this->view->fetch('list_apply_repair',$data);
    }
    public function confirm_apply_repair(){
        $aid = $this->request->param('aid');
        $time = date("Y-m-d",time());
        db('apply_repair')->where('id',$aid)->update(['status' => 7,'updated_at'=>$time]);
        $insert = ['oid' => $aid,'status'=> 7, 'charger' => $this->userinfo['name'],'created_at' => $time,'updated_at'=>$time,'uid' => $this->userinfo['id']];
        db('documentary')->insert($insert);//插入跟单信息
        $this->show_apply_repair();
    }

    

}
