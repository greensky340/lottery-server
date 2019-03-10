<?php
namespace core\lib;
class DateTimeClass{
  public function __construct(){

  }
  // 获取将来的时间 $n是数字 $type是单位，day-天  week-周  month-月  year-年
  public static function getNextTime($n,$type){
    $d = date("Y-m-d H:i:s",strtotime("+$n $type"));
    return $d;
  }
  // 获取过去的时间 $n是数字 $type是单位，day-天  week-周  month-月  year-年
  public static function getLastTime($n,$type){
    $d = date("Y-m-d H:i:s",strtotime("-$n $type"));
    return $d;
  }
}
?>