<?php
session_start();
// 设置允许其他域名访问
header('Access-Control-Allow-Origin:*');  
// 设置允许的响应类型 
header('Access-Control-Allow-Methods:POST, GET');  
// 设置允许的响应头 
header('Access-Control-Allow-Headers:x-requested-with,content-type'); 
// 入口文件=====================================
// 定义常量
// 根目录
define(ROOT,__DIR__);
// 是否开启调试模式
define(DEBUG,true);
// 本站域名
define(SITEURL,"http://myadmin");
// 加载composer加载文件
include "vendor/autoload.php";  
if(DEBUG){
  // 返回详细报错信息
  // $whoops = new \Whoops\Run;
  // $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
  // $whoops->register();
  ini_set("display_errors","On");
}else{
  ini_set("display_errors","Off");
}
// wfwefw();  // 测试报错
//composer输出类
// $someVar = "error";
// dump($someVar);

// 加载函数库
require_once("function.php");
spl_autoload_register('autoload');
// 程序启动
// $app = new App();
// $app->run($controller,$method,$queryString);
// $app->run();
// 获取参数
$uri = $_SERVER["REQUEST_URI"];
$uriArr = explode("/",$uri);
array_shift($uriArr);  //删除数组的第一个元素 是空的
if(empty($uriArr[0])){
  $class = "HelloWorld";
}else{
  $class = $uriArr[0];
}
array_shift($uriArr);  //删除控制器参数
if(empty($uriArr[0])){
  $method = "index";
}else{
  $method = $uriArr[0];
}
array_shift($uriArr);  //删除模型参数
$controllerName = $class."Controller";
if($class==="Admin"){  //访问后台
  $controller = new $controllerName($uriArr,$class,$method);
}else{
  $controller = new $controllerName($uriArr);
}

echo $controller->$method();
?>