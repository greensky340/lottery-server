<?php
use core\lib\Session;
class App{
  public function __construct($queryArr){
    $this->queryArr = $queryArr;
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