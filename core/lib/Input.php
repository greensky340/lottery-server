<?php
// 输入类
namespace core\lib;
use core\common\Pubfun;
class Input{
  // 数据过滤
    static public function checkInput($data) {
        // $data = trim($data);  // 过滤空格 删除的是字符串左右两边的空格，中间的不能过滤掉
        $data = stripslashes($data);  // 删除反斜杠
        $data = str_replace(" ","",$data); //  去掉空格
        $data = strip_tags($data);  // 过滤标签
        $data = addslashes($data);  // 对单引号 斜杠进行转义
        return $data;
        }
        // 获取get数据
        static public function get($name){
        $value = self::checkInput($_GET[$name]);
        if($value==""){
            return -1;
        }
        return $value;
        }
        // 获取post数据
        static public function post($name){
        $value = self::checkInput($_POST[$name]);
        if($value!=""){
        }
        return $value;
    }
    static public function postAll(){
        $data = file_get_contents('php://input');
        if(is_array($data)){
            return $data;
        }
        return json_decode(file_get_contents('php://input'),true);
    }
    // 获取request数据
    static public function request($name){
        $value = self::checkInput($_REQUEST[$name]);
        if($value==""){
            // return -1;
            $data = array();
            $data["code"] = -1;
            $data["msg_id"] = $_REQUEST["msg_id"];
            $data["message"] = $name." is not valid";
            echo json_encode($data);
            exit;
        }
        return $value;
    }
    // 获取request数据id
    static public function requestId($id){
        $value = self::checkInput($_REQUEST[$name]);
        if($value=="" || !is_numeric($value)){  // 如果为空，或者不是数字，提示非法
            return $name." is not valid";
        }
        return $value;
    }
}
?>