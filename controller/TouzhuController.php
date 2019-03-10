<?php
use core\lib\Input;
use core\common\Pubfun;
use core\lib\Check;
class TouzhuController extends App{
    public function __construct(){
    }
    public function touzhu(){
        $postArr = Input::postAll();
        // return Pubfun::returnMsg(array("a"=>"1"));
        $username = $postArr["username"];     // 用户账号
        $msg_id = $postArr["msg_id"];     // 消息号
        $sum_money = $postArr["sum_money"];       // 投注金额
        $bei = $postArr["bei"]; //倍数
        $caipiao_type = $postArr["caipiao_type"];     // 彩票类型
        $quan_id = $postArr["quan_id"];
        $touzhu_id = mt_rand(1000,9999).date("YmdHis").mt_rand(1000,9999);
        $paystatus = 0;  // 支付状态，初始为0
        $status = 0;  // 0-未出票 1-已出票 2-已结束未派奖 3 已经派奖
        $money = Pubfun::useQuan($quan_id,$sum_money,$username,$caipiao_type,$play_type,$touzhu_id);  // 用券之后的价格
        //检查账户余额是否够支付，如果够，paystatus = 1
        $model = $this->getmodel("Touzhu");
        $model->touzhuRecord($touzhu_id,$bei,$username,$caipiao_type,$money,$sum_money,$paystatus,$status);  // 投注总表，记录金额等信息
        switch ($caipiao_type) {
            case 'jczq':    //  竞彩足球
                $data = $this->jczq();
                break;
            case 'jclq':    //  竞彩篮球
                $data = $this->jclq();
                break;
            case 'dlt':     //  大乐透
                $data = $this->dlt($msg_id,$username,$sum_money,$bei,$caipiao_type,$quan_id,$play_type,$touzhu_id,$money,$postArr,$model);
                return Pubfun::returnMsg($data);
                break;
            default:
                $data = "";
                break;
        }
    }
    public function jczq(){  // 竞彩足球
        $data = array();
        $username = Input::request("username");     // 用户账号
        $gameType = Input::request("gameType"); //过关类型
        $chuan = Input::request("chuan"); //串
        $tuijian = Input::request("tuijian"); //是否推荐 1是保密推荐 2是公开推荐 0是不推荐
        $model = $this->getmodel("Touzhu");
        $data = $model->jczq();
    }
    public function dlt($msg_id,$username,$sum_money,$bei,$caipiao_type,$quan_id,$play_type,$touzhu_id,$money,$postArr,$model){  // 大乐透
        $data = array();
        $week = date("w"); //今天是周几
        if ($week == "1" || $week == "3" || $week == "6") { //周一，周三，周六
            $ssq_jiezhi_time = date("H:i:s");
            if ($ssq_jiezhi_time > '20:00:00' && $ssq_jiezhi_time <= '20:15:00') {
                $data["msg_id"] = $msg_id;
                $data["code"] = "-1";
                $data["message"] = "当前时段不能投注";
                return Pubfun::returnMsg($data);
            }
        }
        $touzhuInfo = $postArr["touzhuInfo"];
        $issue = $postArr["issue"];
        $zhuijia = $postArr["zhuijia"];
        $model->touzhuDltInfo($touzhu_id,$issue,$zhuijia);  //当前彩票类型的信息总表，记录倍数，注数，追加等信息
        $result = $model->dlt($touzhu_id,$touzhuInfo);  //投注细化表，记录逐个投注信息，投注号码等
        if($result == 1){
            $data["code"] = 1;
            $data["msg_id"] = $msg_id;
            $data["message"] = '投注完成';
        }else{
            $data["code"] = -1;
            $data["msg_id"] = $msg_id;
            $data["message"] = '投注失败';
        }
        return $data;
    }
}
?>