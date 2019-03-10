<?php
use core\lib\PostRequest;
use core\lib\PdoClass;
use core\lib\PdoMysql;
class HelloWorldModel extends App{
  public function __construct(){
  }
  public function index(){
    $db = lib::pdo();
    var_dump($db);
    // exit;
    $sql = "select * from userinfo";
    $result = $db->query($sql);
    $row = $result->fetchAll();
    // $message = "内容\n";
    // Lib::log($message);
    var_dump($row[0]);
    return $row[0];
  }

  public function pdo(){
    $PdoMysql = new PdoMysql();
    // $sql = "select * from userinfo where cloudGlod = 0";
    // $result = $PdoMysql::getRow($sql);

    // $sql = "update userinfo set cloudGlod = '3'";
    // $result = $PdoMysql::execute($sql);

    // $result = $PdoMysql::findById('userinfo','2');
    // var_dump($result);

    $sql = "select * from userinfo where cloudGlod = ?";
    $arg = array(" '' or 1 = 1");
    $result = PdoMysql::getAll($sql,$arg);
    var_dump($result);

    // $sql = "insert into test (`str`,`time`) value ('str',now())";
    // $result = PdoClass::insert($sql);
    // var_dump($result);
  }
}
?>