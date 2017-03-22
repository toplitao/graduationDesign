<?php
namespace app\Web\Controller;

use think\Request;
use think\View;
use think\Db;
use app\base\CommonBase;

class SearchRepair extends CommonBase
{
    public function search_apply_repair()//方法访问路径 http://localhost/web/apply_repair/write_apply_repair
    {
        
        return $this->view->fetch('search_apply_repair');
    }
    public function list_apply_repair() {
        return $this->view->fetch('list_apply_repair');
    }
    

    

}
