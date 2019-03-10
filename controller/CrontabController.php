<?php
use core\lib\SeasLogClass;
class CrontabController extends App{
    public $seaslog;
    public function __construct(){
        $this->seaslog = new SeasLogClass();
    }
    public function test(){
        $this->seaslog->debug("is debug");
        
    }
    public function sec_30(){  // 30秒1次
        // * * * * * sleep 30; curl http://lottery1.localhost/Crontab/sec_30/
        // * * * * * curl http://lottery1.localhost/Crontab/sec_30/
        // 其实是每分钟执行一次，只不过是第一次执行的url，延时了30秒
        // $this->seaslog->debug("sec 30");
    }
    public function min_1(){  // 1分钟1次
        $model = $this->getmodel("Crontab");
        // $model->log();
        $model->tixian();
    }
    public function min_5(){  // 5分钟

    }
    public function min_10(){  // 10分钟

    } 
    public function min_30(){  //半小时

    }
    public function hour_1(){  // 1小时

    }
    public function hour_2(){  // 2小时

    }
}
?>