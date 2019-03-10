<?php
// 提现
use core\lib\Input;
use core\common\Pubfun;
use core\lib\Check;
class TixianController extends App{
    public function __construct(){

    }
    public function tixian(){  //   申请提现
        $username = Input::request("username");//账号
        $tx_money = Input::request("tx_money");//提现金额
        $tx_pwd = Input::request("tx_pwd");//提现密码
        $msg_id = Input::request("msg_id");//消息号
        $model = $this->getmodel("Tixian");
        $data = $model->tixianAuditing($username,$tx_money,$tx_pwd,$msg_id);
        $data["msg_id"] = $msg_id;
        return Pubfun::returnMsg($data);
    }
}
?>