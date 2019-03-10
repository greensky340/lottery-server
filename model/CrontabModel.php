<?php
use core\lib\SeasLogClass;
use core\lib\RedisClass;
use core\lib\PdoMysql;
class CrontabModel extends App{
    public $seaslog;
    public $redis;
    public function __construct(){
        $this->seaslog = new SeasLogClass();
        $this->redis = new RedisClass();
        $this->PdoMysql = new PdoMysql();
    }
    public function log(){
        $this->seaslog->debug("min-1-test");
    }
    public function tixian(){
        $usernameList = $this->redis->sMembers("tixianList");
        foreach($usernameList as $username){
            $arr = array("time","tx_money");
            $tixianInfoArr = $this->redis->hget("tixian_".$username,$arr);
            //记录提款数据
            $tixian_id = time().rand(100,200);
            $money = $tixianInfoArr["tx_money"];
            $status = 0;
            $tixian_time = $tixianInfoArr["time"];
            $insertArr = array($tixian_id,$username,$money,$status,$tixian_time);
            $sql = "insert into tixian_record (`id`,`username`,`money`,`status`,`tixian_time`) values (?,?,?,?,?)";
            $result = PdoMysql::execute($sql,$insertArr);  // 将redis数据写入数据库
            if($result){
                // 扣除用户账户金额
                $arr = array($money,$money,$username);
                $sql = "update user_info set money = money - ?,jiangjin = jiangjin - ? where username = ?";
                $result = PdoMysql::execute($sql,$arr);
                if($result){
                    $this->redis->sRem("tixianList",$username);  // 删除redis中数据
                    $this->redis->del("tixian_".$username);  // 删除redis中数据
                }
            }
        }
        
    }
}
?>