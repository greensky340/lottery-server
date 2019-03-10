<?php
namespace core\lib;
use core\Conf;
// pdo封装类
class PdoClass{
  public function __construct(){
  }
  static public function conn(){
    $mysqlConfig = Conf::mysqlConfig();
    $dbms='mysql';     //数据库类型
    $host=$mysqlConfig["dbhost"]; //数据库主机名
    $dbName=$mysqlConfig["dbname"];    //使用的数据库
    $user=$mysqlConfig["dbuser"];      //数据库连接用户名
    $pass=$mysqlConfig["dbpass"];          //对应的密码
    $dsn="$dbms:host=$host;dbname=$dbName";
    try {
      $dbh = new \PDO($dsn, $user, $pass); //初始化一个PDO对象
    } catch (PDOException $e) {
      die ("Error!: " . $e->getMessage() . "<br/>");
    }
    return $dbh;
  }
  // 查询
  static public function get($sql,$arg){
    $db = self::conn();
    // $result = $db->query($sql);
    // if($result === false){
    //   var_dump($db->errorInfo());
    //   exit;
    // }else{
    //   $row = $result->fetchAll();
    //   return $row[0];
    // }
    $stmt = $db->prepare($sql);  //准备一条语句
    $res = $stmt->execute($arg);  //执行语句
    if($res){  // 有数据的话
      $row = $stmt->fetchAll();
    }else{
      var_dump($db->errorInfo());
      exit;
    }
    return $row;

  }
  //  插入
  static public function insert($sql){
    $db = self::conn();
    $result = $db->exec($sql);
    if($result === false){
      var_dump($db->errorInfo());
      exit;
    }else{
      return $result;
    }
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