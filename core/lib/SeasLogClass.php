<?php
//日志记录
namespace core\lib;
class SeasLogClass{
  public $seaslog;
  public function __construct(){
    $this->seaslog = new \SeasLog();
  }
  public function getBasePath(){
    // echo "00";
    // echo $this->seaslog::getBasePath();
  }
  public function debug($log){
    \SeasLog::setBasePath("/Users/weizhao/Documents/work/lottery/lottery1-site/log");
    \SeasLog::setLogger("debug");
    \SeasLog::debug($log);
  }
}
?>