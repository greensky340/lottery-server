<?php
use core\lib\Sign;
use core\lib\PostRequest;
use core\lib\Input;
use core\lib\RedisClass;
use core\lib\Check;
class HelloWorldController extends App{
  public function __consturct($queryArr){
    $this->queryArr = $queryArr;
  }
  public function index(){
    $queryArr = $this->queryArr;  // 获取控制器和模型之后的参数
    $md5Result = Sign::md5('1');
    $redis = new RedisClass();
    $redis->setValue('a','11');
    $model = $this->getmodel("HelloWorld");
    $data = $model->index();
    $this->getview("HelloWorld",$data);
  }
  public function post(){
    $email = Input::post("email");  //获取参数
    $result = Check::checkEmail($email);  //检测格式
    if($result == 0){
      echo "format err";
    }else{
      echo $email;
    }
  }
  public function pdo(){
    $queryArr = $this->queryArr;  // 获取控制器和模型之后的参数
    $model = $this->getmodel("HelloWorld");
    $data = $model->pdo();
    print_r($data);
  }
}
?>