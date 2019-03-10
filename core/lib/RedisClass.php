<?php
namespace core\lib;
use core\Conf;
class RedisClass{
    public $redis;
    public function __construct(){
        $redisConfig = Conf::redisConfig();
        $redis = new \Redis();
        $redis->connect($redisConfig["host"],$redisConfig["port"]);
        $redis->auth($redisConfig["auth"]);
        $this->redis = $redis;
    }
    public function setValue($key,$value){
        return $this->redis->set($key,$value);
    }
    public function getValue($key){
        return $this->redis->get($key);
    }
    public function del($key){
        return $this->redis->del($key);
    }
    public function hset($key,$arr){  // 设置hash数据
        if($this->redis->exists($key)){
            return "exists";
        }
        foreach($arr as $field=>$value){
            $this->redis->hset($key,$field,$value);
        }
        return "ok";
    }
    public function hget($key,$arr){  // 取消hash数据
        $result = array();
        foreach($arr as $field){
            $value = $this->redis->hget($key,$field);
            $result[$field] = $value;
        }
        return $result;
    }
    public function sAdd($key,$value){  // 添加数据到集合
        $result = $this->redis->sAdd($key,$value);
        return $result;
    }
    public function sRem($key,$value){  // 从集合中删除指定数据
        $result = $this->redis->sRem($key,$value);
        return $result;
    }
    public function sMembers($key){  // 返回集合下的所有成员
        $result = $this->redis->sMembers($key);
        return $result;
    }
}
?>