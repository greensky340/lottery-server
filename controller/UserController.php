<?php
use core\lib\Input;
use core\common\Pubfun;
use core\lib\Check;
class UserController extends App{
    public $queryArr;
    public function __consturct($queryArr){
        // $this->queryArr = $queryArr;
        $this->queryArr = $_GET;
    }
    // 用户登陆
    public function login(){
        // print_r($this->queryArr);
        $tel = Input::request("tel");
        $pwd = Input::request("pwd");
        $msg_id = Input::request("msg_id");
        $model = $this->getmodel("User");
        $data = $model->login($tel,$pwd);
        $bankInfo = $model->bankinfo($data["username"]);
        $read_status = $model->read_status($data["username"]);
        $get_login_num = $model->get_login_num($data["username"]);
        $zhongjiang_info = $model->zhongjiang_info($data["username"]);
        $data["bankinfo"] = $bankInfo;
        $data["read_status"] = $read_status;
        $data["get_login_num"] = $get_login_num;
        $data["zhongjiang_info"] = $zhongjiang_info;
        $data["msg_id"] = $msg_id;
        return Pubfun::returnMsg($data);
    }
    // 用户注册
    public function reg(){
        $tel = Input::request("tel");
        $pwd = Input::request("pwd");
        $sginCode = Input::request("sginCode");
        $msg_id = Input::request("msg_id");
        $pf = Input::request("pf");
        $regType = Input::request("regType");
        $openid = Input::request("openid");
        $model = $this->getmodel("User");
        $data = $model->reg($tel,$pwd,$sginCode,$regtype,$openid,$pf);  // 注册账号
        return Pubfun::returnMsg($data);
    }
    // 获取注册验证码
    public function reqTelCode(){
        $type = 1;
        $tel = Input::request("tel");
        $result = Pubfun::checkReg($tel,$type);
        if($result < 0){
            //  手机已经被注册
            $data = array();
            $data["msg_id"] = $msg_id;
            $data["code"] = -111;
            $data["message"] = '该手机号已经被注册';
            return Pubfun::returnMsg($data);
        }else{
            $data = array();
            $data["msg_id"] = $msg_id;
            $data["code"] = 0;
            $data["message"] = '请求成功';
            $data["sginCode"] = $data;
            return Pubfun::returnMsg($result);
        }

    }
    // 用户明细
    public function mingxi(){
        $username = Input::request("username");
        $time = Input::request("time");
        $msg_id = Input::request("msg_id");
        if($time==1){  //当天
            $start_time=date("Y-m-d");
        }elseif($time==2){  //最近一周
            $start_time=date("Y-m-d", strtotime("-1 week")); 
        }elseif($time==3){  //最近一个月
            $start_time=date("Y-m-d", strtotime("-1 months")); 
        }elseif($time==4){  //最近三个月
            $start_time=date("Y-m-d", strtotime("-3 months")); 
        }
        $start_time=$start_time." 00:00:00";
        $model = $this->getmodel("User");
        $buyrecord = $model->buyrecord($username,$start_time);
        return Pubfun::returnMsg($buyrecord);
    }
    // 修改手机号码
    public function updateTel(){
        $code_ = Input::request("code"); //注册验证码
        $tel = Input::request("tel");  //注册手机
        $tel = Check::checkTel($tel);  //检测手机格式
        $new_tel = Input::request("new_tel");;  //新手机
        $username = Input::request("username");;  //账号
        $msg_id = Input::request("msg_id");;  //消息号
        $model = $this->getmodel("User");
        $data = $model->updateTel($code_,$tel,$new_tel,$username,$msg_id);
        return Pubfun::returnMsg($data);
    }
    // 用户订单列表
    public function orderList(){
        $postArr = Input::postAll();
        $username = $postArr['username'];
        $model = $this->getmodel("User");
        $orderList = $model->getOrderList($username);
        return Pubfun::returnMsg($orderList);
    }
    // 订单详情
    public function orderInfo(){
        $postArr = Input::postAll();
        $touzhu_id = $postArr['touzhuId'];
        $model = $this->getmodel("User");
        $orderInfo = $model->getOrderInfo($touzhu_id);
        return Pubfun::returnMsg($orderInfo);
    }
}
?>