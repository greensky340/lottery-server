<?php
use core\Conf;
// 常用方法
class lib{
  public function __construct(){
  }
  static public function pdo(){
    $mysqlConfig = Conf::mysqlConfig();
    $dbms='mysql';     //数据库类型
    $host=$mysqlConfig["dbhost"]; //数据库主机名
    $dbName=$mysqlConfig["dbname"];    //使用的数据库
    $user=$mysqlConfig["dbuser"];      //数据库连接用户名
    $pass=$mysqlConfig["dbpass"];          //对应的密码
    $dsn="$dbms:host=$host;dbname=$dbName";
    try {
      $dbh = new PDO($dsn, $user, $pass); //初始化一个PDO对象
    } catch (PDOException $e) {
      die ("Error!: " . $e->getMessage() . "<br/>");
    }
    return $dbh;
  }
  static public function log($message){
    $time = date("Y-m-d H:i:s");
    $message = $time.":".$message;
    $file = __DIR__."/log/".date("Ymd").".txt";
    $reuslt = file_put_contents($file,$message,FILE_APPEND);
    if($reuslt){
      // echo "ok";
    }else{
      // echo "err";
    }
  }
}
?>