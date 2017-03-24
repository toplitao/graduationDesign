<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 自定义JSON返回数据格式
 */
 function dr_show_return($status,$msg,$data=array()) {
	if(!is_numeric($status)){
		$return['status'] = 300;
		$return['msg']    = '状态码错误！必须为数字！';
		goto res;
	}
	if(empty($msg)){
		$return['status'] = 300;
		$return['msg']    = '提示信息不能为空！';
		goto res;
	}
	$return['status'] = $status;
	$return['msg']    = $msg;
	if(!empty($data)){
		$return['data'] = $data;
	}
    res:	
	exit(json_encode($return,JSON_UNESCAPED_UNICODE));
}

/**
 * 获取订单状态函数
 * @param $status  订单状态(int)
 */
function getStatus($status){
    switch($status){
        case 1:
            $code =  '等待确认';
            break;
        case 2:
            $code = '等待分配';
            break;
        case 3:
            $code = '等待维修人员确认';
            break;
        case 4:
            $code = '维修人员确认';
            break;
        case 5:
            $code = '维修完成';
            break;
        case 6:
            $code = '已寄回';
            break;
        case 7:
            $code = '待评价';
            break;
        case 8:
            $code = '已完成';
            break;
        default:
            $code = '未知状态';
            break;
    }
    return $code;
}