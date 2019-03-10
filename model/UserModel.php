<?php
use core\lib\PdoMysql;
class UserModel extends App{
    public $PdoMysql;
    public function __construct(){
        $this->PdoMysql = new PdoMysql();
    }
    // 用户登陆
    public function login($tel,$pwd){
        $data = array();
        $password=md5("123456".$pwd);  //密码加密
        $sql="select * from user_info,user_trueinfo where user_info.tel = ? and ret_type = 'tel' and user_info.username = user_trueinfo.username";
        $arg = array($tel);
        $result = PdoMysql::getRow($sql,$arg);
        if($result != '0'){
            $msg = "登录成功";
            $code = "1";
            $txpwdSetstatus = 0;  //设置二级密码状态 没有设置是0 已经设置是1
            if($result["tx_pwd"]!=""){
                $txpwdSetstatus = 1; 
            }
            if($password == $result["pwd"]){
                $data["tx_pwd"] = $txpwdSetstatus;
                $data["code"] = $code;
                $data["msg"] = $msg;
                $data["id"] = $result["id"];
                $data["username"] = $result["username"];
                $data["money"] = $result["money"];
                $data["nickname"] = $result["nickname"];
                $data["tel"] = $result["tel"];
                $data["topic"] = $result["topic"];
            }else{
                $code = "106";
                $msg = "账号或密码错误";
                $data["code"] = $code;
                $data["msg"] = $msg;
            }
        }else{
            $code = "1000";
            $msg = "没有查到这个账号";
            $data["code"] = $code;
            $data["msg"] = $msg;
        }
        return $data;
    }
    // 用户注册
    public function reg($tel,$pwd,$sginCode,$regtype,$openid,$pf){
        if($regtype == 'tel'){
            $sql = "select username from user_info where tel = ? and regtype = 'tel'";
            $arg = array($tel);
            $result = PdoMysql::getNum($sql,$arg);
            if($result>0){
                return "-1";  // 用户已经注册
            }
            $sql = "select * from telCode where tel = ? and code = ? order by time desc";
            $arg = array($tel,$sginCode);
            $row = PdoMysql::getRow($sql,$arg);
            if($row["tel"] == ""){
                // 没有验证码
            }else{
                $t = time() - $row["time"];
                if($t > 300){
                    // 五分钟超时
                }
                if($sginCode != $row["code"]){
                    // 验证码错误
                }
                // 开始注册
                $password=md5("p@#w#dDw9iudh2187HE37D#".$pwd);  //密码加密
                $tmp=rand(1,9).substr(time(),2,8).rand(1,9);
                $username="bo".$tmp;  //随机分配账号
                $nickname = $username;
                $regtime = time();
                $sql = "insert into user_info (`username`,`money`,`paymoney`,`jiangjin`,`nickname`,`tel`,`pwd`,`txpwd`,`topic`,`regtime`,`regtype`,`openid`,`pf`) values (?,'0','0','0','?,?,?,'','',?,?,'',?)";
                $arg = array($username,$nickname,$tel,$password,$regtime,$regtype,$pf);
                $result = PdoMysql::execute($sql,$arg);
                return $result;
            }
        }
    }
    // 用户银行卡信息
    public function bankinfo($username){
        $sql = "select id,bank_name,bank_card,defalt from user_bankinfo where username = ? order by id asc";
        $arg = array($username);
        $result = PdoMysql::getAll($sql,$arg);
        return $result;
    }
    // 查询用户是否浏览了最新的开奖记录
    public function read_status($username){
        $sql = "select read_status from touzhu_record where read_status = '1' and status = '1' and username = ?";
        $arg = array($username);
        $result = PdoMysql::getRow($sql,$arg);
        if ($result["read_status"] != '0') {
            return "1";     //  有数据
        } else {
            return "2";     //  没有数据
        }
    }
    // 得到登陆次数
    public function get_login_num($username){
        $sql = "select username from login_record where username = ?";
        $arg = array($username);
        $result = PdoMysql::getNum($sql,$arg);
        return $result;
    }
    // 中奖信息
    public function zhongjiang_info($username){
        $r = 0;
        return $r;
        $day = date("Y-m-d");
        $sql = "select username from zhongjiang_window where username = '$username' and day = '$day' limit 0,1";
        $query = mysql_query($sql);
        $n = mysql_num_rows($query);
        if ($n > 0) { //今天已经弹过窗口
            $r = 0;
        } else { //如果没有弹过
            $sql = "select sum(change_num) as change_num from money_record where reason_id = '4' and time between '" . $day . " 00:00:00' and '" . $day . " 23:59:59' and username = '$username'";
            $query = mysql_query($sql);
            $row = mysql_fetch_array($query);
            $r = $row["change_num"];
            if ($r > 0) {
                mysql_query("insert into zhongjiang_window values ('$username','$r','$day',now())");
            } else {
                $r = 0;
            }
        }
        return $r;
    }
    // 购彩明细
    public function buyrecord($username,$starttime){
        $buy_arr=array();
        $buy_sum=0;
        $sql = "select date_format(time,'%Y-%m-%d') as day from money_record where time >= ? and username = ? and reason_id = '2' group by day order by day desc";
        $arg = array($starttime,$username);
        $result = PdoMysql::getAll($sql,$arg);
        foreach($result as $arr){
            $day = $arr["day"];
            $buy_day_arr=array();
            $sql="select * from money_record where time between '$day 00:00:00' and '$day 23:59:59' and username = ? and reason_id = '2' order by time desc";  //查询每一天的数据
            $arg = array($username);
            $day_result = PdoMysql::getAll($sql,$arg);
            foreach($day_result as $row){
                $buy_sum=$buy_sum+$row["change_num"];  //总数
                array_push($buy_day_arr,$row);  //将当天的N条的数据组成数据
            }
            $buy_arr[$day]=$buy_day_arr;  //将一整天的数据，作为一个值，放到buy_arr的数据中，数组的键值是日期
            unset($buy_day_arr);
        }
        return $buy_arr;
    }
    // 修改手机号
    public function updateTel($code_,$tel,$new_tel,$username,$msg_id){
        $data = array();
        $sql="select * from user_info where tel = ?";
        $arg = array($new_tel);
        $n = PdoMysql::getNum($sql,$arg);
        if($n>0){
            $data["msg_id"] = $msg_id;
            $data["code"] = 116;
            $data["message"] = "手机号已经存在";
            return $data;
        }
        $times=time();
        $sql="select code,time from tel_sign_code where tel = ? and type = '5' order by time desc";
        $arg = array($new_tel);
        $row = PdoMysql::getRow($sql,$arg);
        $code=$row["code"];
        $time=$row["time"];
        $r=$times-$time;
        if($r>60000){
            $data["msg_id"] = $msg_id;
            $data["code"] = 103;
            $data["message"] = "验证码过期";
            return $data;
        }
        if($code==$code_){  //验证码正确 开始绑定
            $sql="update user_info set tel = ? where username = ?";
            $arg = array($new_tel,$username);
            $result = PdoMysql::execute($sql,$arg);
            if($result){
                $data["msg_id"] = $msg_id;
                $data["code"] = 1;
                $data["message"] = "绑定成功";
                $data["tel"] = $new_tel;
                return $data;
            }
        }else{
            $data["msg_id"] = $msg_id;
            $data["code"] = -1;
            $data["message"] = "验证码错误";
            $data["tel"] = $new_tel;
            return $data;
        }
    }
    // 获取用户投注订单
    public function getOrderList($username){
        $sql = "select * from touzhu_record where username = ? order by touzhu_time desc";
        $arg = array($username);
        $data = PdoMysql::getAll($sql,$arg);
        return $data;
    }
    // 获取订单详情
    public function getOrderInfo($touzhu_id){
        $sql = "select * from touzhu_lotto where touzhu_id = ?";
        $arg = array($touzhu_id);
        $data = PdoMysql::getAll($sql,$arg);
        return $data;
    }
}
?>