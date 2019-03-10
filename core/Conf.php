<?php
namespace core;
class Conf{
  // mysql数据库配置
  static public function mysqlConfig(){
    $arr = array();
    $arr["dbms"] = "mysql";
    $arr["dbhost"] = "127.0.0.1";
    $arr["dbname"] = "lottery";
    $arr["dbuser"] = "root";
    $arr["dbpass"] = "";
    $arr["charset"] = "utf8";
    return $arr;
  }
  // redis配置
  static public function redisConfig(){
    $arr = array();
    $arr["host"] = "127.0.0.1";
    $arr["port"] = "6379";
    $arr["auth"] = "123456";
    return $arr;
  }
}
?>