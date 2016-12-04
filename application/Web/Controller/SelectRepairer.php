<?php
    namespace app\Web\Controller;

    use think\Request;
    use think\View;
    use think\Db;
    class SelectRepairer
    {
        public $id=1;

        public function index(){
            db('applyrepair')->where('id',$this->id)->setField('status',2);
            $this->select_repairer();
        }
        public function select_repairer(){
            $info=db('applyrepair')->where('id',$this->id)->find();
            $address_data=db('linkaddress')->where('id','$info[address]')->find();//查询订单位置信息
            $level=count(explode(',',$address_data['pids']));
            if($level==1){//直辖市
                $repairer_data=db('repairperson')->where('repairAddress',info['address']);
            }esle{//省
                $repairer_data=db('repairperson')->where('repairAddress',info['address']);
            }
            print_r($repairer_data);
        }
    }


?>