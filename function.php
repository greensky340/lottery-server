<?php
// 自动加载类
function autoload($classname){
  if(substr($classname,-5)=="Model"){
    $filename = ROOT."/model/".$classname.".php";
    if (file_exists($filename))
    require $filename;
  }elseif(substr($classname,-10)=="Controller"){
    $filename = ROOT."/controller/".$classname.".php";
    if (file_exists($filename))
    require $filename;
  }else{
    $classname = str_replace('\\','/',$classname);
    $filename = ROOT."/".$classname.".php";
    if (file_exists($filename))
    require $filename;
  }
}
?>