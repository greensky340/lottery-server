<?php
use core\lib\PostRequest;
use core\lib\Session;
use core\lib\SeasLogClass;
use core\lib\PdoMysql;
class AdminModel extends AdminApp{
  public $db;
  public $seaslog;
  public $PdoMysql;
  public function __construct(){
    $this->db = lib::pdo();
    $this->seaslog = new SeasLogClass();
    $this->PdoMysql = new PdoMysql();
  }
  public function login($username,$password){
    // $password = md5('!QAZXw23e$%'.$password);
    // $sql = "select * from admin_users where username = '$username' and password = '$password'";
    // $result = $this->db->query($sql);
    // $row = $result->fetchAll();
    // $permission = $row[0]["permission"];
    // $n = $result->rowCount(); // 受影响的记录数
    // if($n>0){  // 设置session 和过期时间
    //   $admin = array();
    //   $admin["username"] = $username;
    //   $admin["time"] = time();
    //   $admin["permission"] = $permission;
    //   Session::set("admin",$admin);
    //   return "ok";
    // }else{
    //   return "error";
    // }
    $password = md5('!QAZXw23e$%'.$password);
    $sql = "select * from admin_users where username = ? and password = ?";
    $arg = array($username,$password);
    $result = PdoMysql::getNum($sql,$arg);
    if($result>0){
      $admin = array();
      $admin["username"] = $username;
      $admin["time"] = time();
      $admin["permission"] = $result[0]["permission"];;
      Session::set("admin",$admin);
      return "ok";
    }else{
      return "error";
    }
  }
  public function getActiveList(){
    $this->seaslog->getBasePath();
    $this->seaslog->debug("is debug");
    $sql = "select * from active_info order by addtime desc";
    $result = $this->db->query($sql);
    $row = $result->fetchAll();
    return $row;
  }
  public function getActiveInfo($activeId){
    $sql = "select * from active_info where id = '$activeId' order by addtime desc";
    $result = $this->db->query($sql);
    $row = $result->fetchAll();
    return $row;
  }
  public function getMenuList(){
    $sql = "select * from admin_menu order by created_at desc";
    $result = $this->db->query($sql);
    $row = $result->fetchAll();
    return $row;
  }
  public function getMenuId($uri){
    $sql = "select id from admin_menu where uri = '$uri'";
    $result = $this->db->query($sql);
    $row = $result->fetchAll();
    return $row[0][0];
  }
  public function menuAdd($title,$uri,$icon,$order,$parentId){
    $sql = "insert into admin_menu (`parent_id`,`order`,`title`,`icon`,`uri`,`permission`,`created_at`,`updated_at`) values ('$parentId','$order','$title','$icon','$uri','0',now(),now())";
    $result = $this->db->query($sql);
    return $result->rowCount(); // 受影响的记录数
  }
  public function adminList(){
    $sql = "select * from admin_users order by created_at desc";
    // return $sql;
    $result = $this->db->query($sql);
    $row = $result->fetchAll();
    return $row;
  }
  public function adminAdd($username,$password,$name,$check){  //添加管理员
    $check = urldecode($check);
    $password = md5('!QAZXw23e$%'.$password);
    $sql = "insert into admin_users (`username`,`password`,`name`,`permission`,`avatar`,`remember_token`,`created_at`,`updated_at`) values ('$username','$password','$name','$check','','',now(),now())";
    // return $sql;
    $result = $this->db->query($sql);
    return $result->rowCount(); // 受影响的记录数
  }
  public function touzhuList(){  // 投注列表
    $sql = "select * from touzhu_record order by touzhu_time desc";
    // return $sql;
    $result = $this->db->query($sql);
    $row = $result->fetchAll();
    return $row;
  }
}

?>