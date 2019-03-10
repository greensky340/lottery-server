<?php
use core\lib\Input;
class AdminController extends AdminApp{
  public function __consturct(){
  }
  public function login(){
    // $username = Input::post("username");
    $username = $_POST["username"];
    $password = Input::post("password");
    if($username != "" && $password != ""){
      $model = $this->getmodel("Admin");
      $result = $model->login($username,$password);
      if($result=="ok"){
        // 登陆成功
        // echo "login success";
        header("Location:/Admin/adminAdd");
      }else{
        header("Location:/Admin/login");
      }
    }
    $this->getview("admin/login",$this->data);
  }
  public function getActiveList(){
    $model = $this->getmodel("Admin");
    $result = $model->getActiveList();
    $this->data["activeList"] = $result;
    $this->getview("admin/activeList",$this->data);
  }
  public function getActiveInfo(){
    $activeId = $this->queryArr[0];
    $model = $this->getmodel("Admin");
    $result = $model->getActiveInfo($activeId);
    $this->data = $result[0];
    $this->getview("admin/activeInfo",$this->data);
  }
  public function getMenuList(){  //菜单列表
    $model = $this->getmodel("Admin");
    $result = $model->getMenuList();
    $this->data["menuList"] = $result;
    $this->getview("admin/menuList",$this->data);
  }
  public function MenuAdd(){  //添加菜单
    if(Input::post("submit")){  //增加菜单
      $title = Input::post("title");
      $uri = Input::post("uri");
      $icon = Input::post("icon");
      $order = Input::post("order");
      $parentId = Input::post("parentId");
      $model = $this->getmodel("Admin");
      // echo $title."-".$uri."-".$icon."-".$order."-".$parentId;
      // exit;
      $result = $model->menuAdd($title,$uri,$icon,$order,$parentId);
      echo $result;
    }else{  //显示页面
      $model = $this->getmodel("Admin");
      $result = $model->getMenuList();
      $this->data["menuList"] = $result;
      $this->getview("admin/MenuAdd",$this->data);
    }
    
  }
  public function adminAdd(){  //添加管理员
    if(Input::post("submit")){
      $username = Input::post("username");
      $password = Input::post("password");
      $name = Input::post("name");
      $check = Input::post("check");
      $model = $this->getmodel("Admin");
      $result = $model->adminAdd($username,$password,$name,$check);
      echo $result; 
    }else{
      $model = $this->getmodel("Admin");
      $result = $model->getMenuList();
      $this->data["menuList"] = $result;
      $this->getview("admin/adminAdd",$this->data);
    }
  }
  public function adminList(){  //管理员列表
    $model = $this->getmodel("Admin");
    $adminList = $model->adminList();
    $this->data["adminList"] = $adminList;
    $this->getview("admin/adminList",$this->data);
  }
  public function touzhuList(){  //  投注列表
    $model = $this->getmodel("Admin");
    $touzhuList = $model->touzhuList();
    $this->data["touzhuList"] = $touzhuList;
    $this->getview("admin/touzhuList",$this->data);
  }
}
?>