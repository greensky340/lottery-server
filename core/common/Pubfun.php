<?php
namespace core\common;
use core\lib\PdoMysql;
class Pubfun{
    public function __construct(){
        $this->PdoMysql = new PdoMysql();
    }
    public static function returnMsg($array){  // 统一返回消息格式
        $json = json_encode($array);
        return $json;
    }
    public static function useQuan($quan_id,$money,$username,$caipiao_type,$touzhu_id){
        // 如果没有券ID，直接返回
        if ($quan_id == '0') return $money;
        // 读出券信息
        $sql = "select * from user_quan where quan_id = ? and quan_status = '0'";
        $arg = array($quan_id);
        $row = PdoMysql::getRow($sql,$arg);
        // 判断券的使用状态是否合法
        if ($row["quan_status"] != 0) return -1;
        // 判断券是否在有效期内
        $currentDate = date("Y-m-d") . "00:00:01";
        if ($row["quan_starttime"] > $currentDate || $row["quan_endtime"] < $currentDate) return -2;
        // 判断彩种是否可以使用该券
        $isOk = 0;
        switch ($row["quan_useby"]) {
            case 1: // 全场通用
                $isOk = 1;
            break;
            case 2: // 竞彩足球
                $isOk = ($caipiao_type == 'jczq') ? 1 : 0;
            break;
            case 3: // 竞彩蓝球
                $isOk = ($caipiao_type == 'jclq') ? 1 : 0;
            break;
            case 4: // 大乐透
                $isOk = ($caipiao_type == 'lotto') ? 1 : 0;
            break;
            case 5: // 排列三
                $isOk = ($caipiao_type == 'pai3') ? 1 : 0;
            break;
            case 6: // 排列五
                $isOk = ($caipiao_type == 'pai5') ? 1 : 0;
            break;
            case 7: // 十一选五
                $isOk = ($caipiao_type == 'bj11x5' || $caipiao_type == 'sd11x5' || $caipiao_type == 'gd11x5') ? 1 : 0;
            break;
            case 8: // 江西快3
                $isOk = ($caipiao_type == 'jxk3') ? 1 : 0;
            break;
            case 9: // 双色球
                $isOk = ($caipiao_type == 'ssq') ? 1 : 0;
            break;
        }
        if ($isOk != 1) return -3;
        // 根据类型号，判断是否满足使用金额
        switch ($row["quan_type"]) {
            case 1: // 满10减
                $isOk = ($money < 10) ? 0 : 1;
            break;
            case 2: // 满20减
                $isOk = ($money < 20) ? 0 : 1;
            break;
            case 3: // 满50减
                $isOk = ($money < 50) ? 0 : 1;
            break;
            case 4: // 直减
                $isOk = 1;
            break;
        }
        if ($isOk != 1) return -4;
        // 可以使用，更新券的投注ID
        $arg = array($touzhu_id,$quan_id);
        $sql = "update user_quan set touzhu_id = '$touzhu_id',status = '1' where quan_id = '$quan_id'";
        PdoMysql::execute($sql,$arg);
        $sql = "update touzhu_record set quan_id = '$quan_id' where touzhu_id = '$touzhu_id'";
        PdoMysql::execute($sql,$arg);
        // 计算实际需要支付的数额
        $realMoney = $money - $row["quan_money"];
        return $realMoney;
    }
    public static function checkReg($tel,$type){  // 获取手机号码
        if($type == 1){  // 用户注册
            $sql = "select username from user_info where tel = ?";
            $arg = array($tel);
            $result = PdoMysql::getNum($sql,$arg);
            if($result>0){
                return "-1";
            }
        }
        $code = mt_rand(1000,9999);
        $sql = "insert into telCode (`tel`,`code`,`time`) values (?,?,?)";
        $arg = array($tel,$code,time());
        $result = PdoMysql::execute($sql,$arg);
        if($result){
            // 调用接口 发短信
            return $code;
        }
    }

}
?>