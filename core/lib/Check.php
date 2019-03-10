<?php
namespace core\lib;
use core\common\Pubfun;
class Check{
    // 检测邮件
    static public function checkEmail($email){
        $result = 1;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $result = 0;  //非法邮箱格式
        }
        return $result;
    }
    // 检测电话
    static public function checkTel($value){
        // if(preg_match("/^1[34578]{1}\d{9}$/",$tel)){  
        // }else{  
        //     echo '{"msg_id":"'.$msg_id.'","code":"107","message":"手机号码格式错误"}';
        //     exit;
        // }
        return $value;
    }
    // 检测是否为数字
    static public function checkNumber($value){
        return $value;
    }
}
?>