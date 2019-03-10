<?php
namespace core\lib;
use core\lib\SeasLogClass;
class PostRequest{
    static function test(){
        echo "test";
    }
    static function curl_post($url, $postData) {
        // $postData = json_encode($postData);  // 数据格式是json
        $curl = curl_init();  //初始化
        curl_setopt($curl,CURLOPT_URL,$url);  //设置url
        curl_setopt($curl,CURLOPT_HTTPAUTH,CURLAUTH_BASIC);  //设置http验证方法
        curl_setopt($curl, CURLOPT_TIMEOUT,3);   //只需要设置一个秒的数量就可以
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);  //设置curl_exec获取的信息的返回方式
        curl_setopt($curl,CURLOPT_POST,1);  //设置发送方式为post请求
        curl_setopt($curl,CURLOPT_POSTFIELDS,$postData);  //设置post的数据
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(  // 数据格式是json
            'Content-Type: application/json',
            'Content-Length: ' . strlen($postData))
        );
        $result = curl_exec($curl);
        if($result === false){
            if(curl_errno($curl) == CURLE_OPERATION_TIMEDOUT){
                //超时的处理代码
                $message = $url.":Request timeout";
                $seaslog = new SeasLogClass();
                $seaslog->debug($message);
            }
        }
        curl_close($curl);
    }
}
?>