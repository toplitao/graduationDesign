<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;
use think\View;
use think\Session;
// return [
//     '__pattern__' => [
//         'name' => '\w+',
//     ],
//     '[hello]'     => [
//         ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//         ':name' => ['index/hello', ['method' => 'post']],
//     ],

// ];
Route::get('/register',function(View $view){
    $data['list'] = Db('station')->select();
    return $view->fetch('index@index/register',$data);
});
Route::get('/login',function(View $view){
    return $view->fetch('index@index/login');
});
Route::get('/',function(View $view){
    $data['code'] = 1;
    $data['userInfo'] = Session::get('userinfo');
    return $view->fetch('web@home/home',$data);
});
