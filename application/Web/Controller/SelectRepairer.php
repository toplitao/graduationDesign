<?php
    namespace app\Web\Controller;

    use think\Request;
    use think\View;
    use think\Db;
    class SelectRepairer
    {
        public $oid=1;
        public $rid=0;
        public function __construct(){
            $this->view=new View;
            $this->request=Request::instance();
        }
        public function index(){//客服点击按钮接收申请操作方法
            $this->oid=$this->request->param();
            $order_info=db('applyrepair')->where('id',$this->oid)->find();
            if($order_info['status']<2){
                 db('applyrepair')->where('id',$this->oid)->setField('status',2);
                 $this->select_repairer();
            }else{
               return $msg='该订单无需进行此操作';
            }
        }
        public function near_repairer(){//维修人员查询
            $info=db('applyrepair')->where('id',$this->id)->find();
            $address_data=db('linkaddress')->where('id','$info[address]')->find();//查询订单位置信息
            $level=count(explode(',',$address_data['pids']));
            if($level==1){//直辖市
                $repairer_data=db('repairperson')
                                ->where('repairAddress',info['address'])
                                ->where('status',1)
                                ->select();
            }else{//省
                $repairer_data=db('repairperson')
                                ->where('repairAddress','in',info['address'])
                                ->where('status',1)
                                ->select();
            }
            if(empty($repairer_data)){//调用百度地图获取周围城市维修人员
                
            }
        }
        public function assign_repairer(){//分配人员执行操作
            $this->rid=$this->request->param();
            $up_data=array(
                'aid'=>$this->oid,
                'status'=>$this->rid
            );
            db('repairperson')->where('id',$this->rid)->update($up_data);
            db('applyrepair')->where('id',$this->oid)->setField('status',3);
        }
    }


?>