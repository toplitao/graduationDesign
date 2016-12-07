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
 function dr_show_return($status,$msg,$url='',$data=array()) {
	if(!is_numeric($status))
	{
		$return['status'] = 0;
		$return['msg']    = '状态码错误！必须为数字！';
		goto res;
	}
	if(empty($msg))
	{
		$return['status'] = 0;
		$return['msg']    = '提示信息不能为空！';
		goto res;
	}
	$return['status'] = $status;
	$return['msg']    = $msg;
	if(!empty($url)){
		$return['url'] = $url;
	}
	if(!empty($data)){
		$return['data'] = $data;
	}
    res:	
	exit(json_encode($return,JSON_UNESCAPED_UNICODE));
}