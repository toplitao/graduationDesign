<?php
namespace app\base;

use think\Session;
use think\Controller;
use think\Request;
use think\View;

class CommonBase extends Controller{
    protected $view;
    protected $request;
    public function __construct(){
        parent::__construct();
        $this->view=new View;
        $this->request=Request::instance();
    }

    protected function _OnInit(){
        $userinfo = Session::get('userinfo');
        return $userinfo;
    }

    /**
     * 通用curl操作方法
     * @param $url  接口地址
     * @param string $type   请求方式 默认为get
     * @param string $res    数据返回格式，默认为json
     * @param string $arr    传递的参数，如果为post方式则填写此项
     */
    public function http_curl($url,$type='get',$res='json',$arr=''){
        //1.初始化curl
        $ch = curl_init();
        //2.设置curl参数
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        if($type == 'post'){
            curl_setopt($ch,CURLOPT_PORT,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$arr);
        }
        //3.数据采集
        $output = curl_exec($ch);
        //4.数据处理
        if($res == 'json'){
            if(curl_errno($ch)){
                return curl_error($ch);//输出错误信息
            }else{
                return json_decode($output,true);
            }
        }
        //5.关闭
        curl_close($ch);

    }

    /**
     * 通用下载文件操作
     * @param $filename 文件key值
     */
    public function downloadFile($filename){
        $filename = $this->request->param($filename);
        header('content-disposition:attachment;filename='.basename($filename));
        header('content-length:'.filesize($filename));
        readfile($filename);
    }

    /**
     * 获取所有新闻栏目分类
     */
     public function getAllNews(){
         $data = db('news')->select();
         return $data;
     }


}