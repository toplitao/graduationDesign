<?php
    namespace app\Web\Controller;

    use think\Request;
    use think\View;
    use think\Db;
    use app\BaseController\CommonBase;
    class SelectRepairer extends CommonBase
    {
        public $oid=1;
        public function index(){//客服点击按钮接收申请操作方法
            $this->oid=$this->request->param();
            $order_info=db('applyrepair')->where('id',$this->oid['oid'])->find();
            if($order_info['status']==0){
                 db('applyrepair')->where('id',$this->oid['oid'])->setField('status',1);
                 $this->near_repairer($order_info);
            }else{
               return $msg='该订单无需进行此操作';
            }
        }
        public function near_repairer($order_info){//维修人员查询
             $repairer_data=db('user')
                            ->where('repairAddress',$order_info['address'])
                            ->where('status',1)
                            ->where('level',2)
                            ->select();
            if(empty($repairer_data)){//调用百度地图最近城市维修员信息
                $order_info['lng']=116.4;
                $order_info['lat']=39.9;
                $url_header='http://api.map.baidu.com/routematrix/v2/driving?output=json';
                $key='p8YDvzG00pn20TxG9rK9DKskgr5Fxdzq';
                $origins=$order_info['lat'].','.$order_info['lng'];
                $address_info=db('linkaddress')
                                ->where('lng','<>',$order_info['lng'])
                                ->where('lat','<>',$order_info['lat'])
                                ->select();
                                $destinations=NULL;
                foreach($address_info as $k =>$v){
                    $destinations.=$v['lat'].','.$v['lng'].'|';
                }
                $destinations=substr($destinations,0,-1);
                $url=$url_header.'&origins='.$origins.'&destinations='.$destinations.'&ak='.$key;
                $json_result=file_get_contents($url);
                $result=json_decode($json_result,true);
                $result_data=$result['result'];
                for($i=0;$i<count($result_data);$i++){
                    $result_data[$i]['location']['id']=$address_info[$i]['id'];
                    $result_data[$i]['location']['addressname']=$address_info[$i]['name'];
                    if($i>0&&$result_data[$i]['distance']['value']!=0){
                        for ($j = $i; $j > 0; $j--) {
                            if ($result_data[$j]['distance']['value'] < $result_data[$j - 1]['distance']['value']) {
                                $arr_mid = $result_data[$j - 1];
                                $result_data[$j - 1] = $result_data[$j];
                                $result_data[$j] = $arr_mid;
                            } else {
                                break;
                            }
                        }
                    }
                }
                foreach($result_data as $k => $value){
                    $repairer_data=db('user')
                                    ->where('repairAddress',$value['location']['id'])
                                    ->where('status',1)
                                    ->where('level',2)
                                    ->select();
                    if(!empty($repairer_data)){
                         $location_info=db('linkaddress')
                                ->where('id',$repairer_data['repairAddress'])
                                ->find();
                         $location=$location_info['name'];
                    }
                }print_r($repairer_data);exit;
                /*http://api.map.baidu.com/routematrix/v2/driving?output=json&origins=40.45,116.34|40.54,116.35&destinations=40.34,116.45|40.35,116.46&ak=p8YDvzG00pn20TxG9rK9DKskgr5Fxdzq*/
            }else{
                $location_info=db('linkaddress')
                                ->where('id',$order_info['address'])
                                ->find();
                $location=$location_info['name'];
            }
            print_r($location_info);exit;
            return $this->view->fetch('select_repairer_list',['list'=>$repairer_data,'location'=>$location,'oid'=>$order_info['id']]);
        }
        public function assign_repairer(){//分配人员执行操作
            $this->oid=$this->request->param();
            $repairer_info=db('user')->where('id',$this->user['id'])->find();
            $order_info=db('applyrepair')->where('id',$this->oid['oid'])->find();
            if($repairer_info['status']==1){
                $up_data_r=array(
                                'aid'=>$this->oid['oid'],
                                'status'=>2
                            );
                $up_data_a=array(
                                'backNumber'=>time().$this->oid['oid'],
                                'status'=>2
                            );
                db('user')->where('id',$this->user['id'])->update($up_data_r);
                db('applyrepair')->where('id',$this->oid['oid'])->update($up_data_a);
            }
           
            
        }
    }


?>