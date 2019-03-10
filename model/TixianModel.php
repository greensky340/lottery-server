<?php
use core\lib\RedisClass;
use core\lib\PdoMysql;
class TixianModel extends App{
    public $PdoMysql;
    public $redis;
    public function __construct(){
        $this->redis = new RedisClass();
        $this->PdoMysql = new PdoMysql();
    }
    public function tixianNotAuditing($username,$tx_money,$tx_pwd,$msg_id){  //提现，不需要审核
        
    }
    public function tixianAuditing($username,$tx_money,$tx_pwd,$msg_id){  // 提现 需要审核
        $data = array();
        //验证提现密码
        //验证数据库中是否有未完成的提款记录
        $sql = "select * from tixian_record where username = ? and status = '0'";
        $arg = array($username);
        $n = PdoMysql::getNum($sql,$arg);
        if($n>0){
            $data["code"] = "-1";
            $data["message"] = "有尚未完成的提款记录";
            return $data;
        }
        //验证账户金额
        $sql = "select jiangjin from user_info where username = ?";
        $arg = array($username);
        $result = PdoMysql::getRow($sql,$arg);
        if($result["jiangjin"] < $tx_money){
            $data["code"] = "-2";
            $data["message"] = "账户金额不足";
            return $data;
        }
        //写入redis
        $arr = array();
        $arr["tx_money"] = $tx_money;
        $arr["time"] = date("Y-m-d H:i:s");
        $key = "tixian_".$username;
        $result = $this->redis->hset($key,$arr);
        if($result == "exists"){
            // 已经存在
            $data["code"] = "-1";
            $data["message"] = "有尚未完成的提款记录";
            return $data;
        }else{
            $this->redis->sAdd("tixianList",$username);
            $data["code"] = "1";
            $data["message"] = "提交成功";
            return $data;
        }
    }
}
?>