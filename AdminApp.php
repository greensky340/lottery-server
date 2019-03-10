<?php
use core\lib\Session;
class AdminApp{
  public $adminInfo = array();
  public function __construct($queryArr,$class,$method){
    $this->queryArr = $queryArr;
    $this->adminInfo = Session::get("admin");
    $this->data=array();
    $this->model = $this->getmodel("Admin");
    $uri = "/".$class."/".$method;
    $leftList = $this->model->getMenuList();
    $menuId = $this->model->getMenuId($uri);
    // 访问权限检测
    if($method != "login" && $method != "loginOut"){  //登陆和退出登陆两个uri不验证登陆状态
      if(time()-$this->adminInfo["time"]>1800){  //登陆过期 一小时
        header("Location:/Admin/login");
      }else{  //刷新时间
        $this->adminInfo["time"] = time();
        Session::set("admin",$this->adminInfo);
      }
      if($this->adminInfo["username"]!="admin"){  //超级管理员不检测权限
        $permission = json_decode($this->adminInfo["permission"]); // 权限数组
        $result = 0;
        if(in_array($menuId,$permission)){
          $result = 1;
        }
        if($result == 0){
          echo "no permission";
          exit;
        }
      }
    }
    $this->data["adminInfo"] = $this->adminInfo;
    $this->data["leftList"] = $leftList;
  }
  // 调用view模版文件
  public function getview($class,$data){
    extract($data);  // 将数组中的键定义为变量
    $file = __DIR__."/view/".$class.".php";
    if(is_file($file)){
      require $file;
    }
  }
  public function getmodel($class){
    $class = $class."Model";
    $model = new $class();
    return $model;
  }
}
?>