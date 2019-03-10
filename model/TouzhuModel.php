<?php
use core\sendpiao\Nuomi;
use core\lib\PdoMysql;
class TouzhuModel extends App{
    public function __construct(){
        $this->PdoMysql = new PdoMysql();
    }
    public function touzhuRecord($touzhu_id,$bei,$username,$caipiao_type,$money,$sum_money,$paystatus,$status){  // 记录到touzhu_record表
        $addtime = date("Y-m-d H:i:s");
        $insertArr = array($touzhu_id,$username,$caipiao_type,$money,$sum_money,$addtime,$addtime,$paystatus,$status);
        $sql = "insert into touzhu_record (`touzhu_id`,`username`,`caipiao_type`,`money`,`sum_money`,`touzhu_time`,`jiedan_time`,`paystatus`,`status`) values (?,?,?,?,?,?,?,?,?)";
        $result = PdoMysql::execute($sql,$insertArr);
        return $result;
    }
    public function jczq(){  // 记录投注信息 然后调用出票接口
        echo "touzhu-jczq";
        Nuomi::sendPiao();
    }
    public function touzhuDltInfo($touzhu_id,$issue,$zhuijia){  //大乐透的信息总表 是否追加，追加等信息
        $addtime = date("Y-m-d H:i:s");
        $insertArr = array($touzhu_id,$issue,$zhuijia,$addtime);
        $sql = "insert into touzhu_lotto_info (`touzhu_id`,`issue`,`zhuijia`,`addtime`) values (?,?,?,?)";
        $result = PdoMysql::execute($sql,$insertArr);
        return $result;
    }
    public function dlt($touzhu_id,$touzhuInfo){  // 大乐透投注
        $addtime = date("Y-m-d H:i:s");
        foreach ($touzhuInfo as $codeinfo){
            $red = implode(',',$codeinfo["red"]);
            $red_d = implode(',',$codeinfo["red_d"]);
            $red_t = implode(',',$codeinfo["red_t"]);
            $blue = implode(',',$codeinfo["blue"]);
            $blue_d = implode(',',$codeinfo["blue_d"]);
            $blue_t = implode(',',$codeinfo["blue_t"]);
            $play_type = $codeinfo["play_type"];
            $insertArr = array($touzhu_id,$play_type,$red,$red_d,$red_t,$blue,$blue_d,$blue_t,$addtime);
            $sql = "insert into touzhu_lotto (`touzhu_id`,`play_type`,`red`,`red_d`,`red_t`,`blue`,`blue_d`,`blue_t`,`addtime`) values (?,?,?,?,?,?,?,?,?)";
            $result = PdoMysql::execute($sql,$insertArr);
        }
        return $result;
    }
}
?>