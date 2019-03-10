<?php
namespace core\lib;
use core\Conf;
class PdoMysql {
    public static $link = null; //保存链接标示符
    public static $connected = false; //是否链接成功
    public static $PDOStatement = null; //pdo结果对象
    public static $queryStr = null; //保存之后执行的操作
    public static $errInfo = ""; // 保存错误信息
    public static $lastInsertId = ""; //最后插入数据的id
    public static $numRows = 0; //增删改受影响的条数
    public function __construct($mysqlConfig = "") {
        if (!class_exists("PDO")) {
            self::throw_excption("不支持PDO，请先开启");
        }
        if (!is_array($mysqlConfig)) { // 如果没有通过构造函数传入数据库配置信息，则从配置文件中读取默认信息
            $mysqlConfig = Conf::mysqlConfig();
        }
        $dbms = $mysqlConfig["dbms"]; //数据库类型
        $host = $mysqlConfig["dbhost"]; //数据库主机名
        $dbName = $mysqlConfig["dbname"]; //使用的数据库
        $user = $mysqlConfig["dbuser"]; //数据库连接用户名
        $pass = $mysqlConfig["dbpass"]; //对应的密码
        $dsn = "$dbms:host=$host;dbname=$dbName";
        if (!isset($link)) {
            try {
                self::$link = new \PDO($dsn, $user, $pass); //初始化一个PDO对象
            }
            catch(PDOException $e) {
                die("Error!: " . $e->getMessage() . "<br/>");
            }
            if (!self::$link) {
                self::throw_excption("PDO链接错误");
                return false;
            }
            self::$link->exec("SET NAMES " . $mysqlConfig["charset"]); // 设置编码
            self::$connected = true;
            unset($mysqlConfig);
        }
    }
    public static function conn(){  // 链接数据库
        if (!class_exists("PDO")) {
            self::throw_excption("不支持PDO，请先开启");
        }
        if (!is_array($mysqlConfig)) { // 如果没有通过构造函数传入数据库配置信息，则从配置文件中读取默认信息
            $mysqlConfig = Conf::mysqlConfig();
        }
        $dbms = $mysqlConfig["dbms"]; //数据库类型
        $host = $mysqlConfig["dbhost"]; //数据库主机名
        $dbName = $mysqlConfig["dbname"]; //使用的数据库
        $user = $mysqlConfig["dbuser"]; //数据库连接用户名
        $pass = $mysqlConfig["dbpass"]; //对应的密码
        $dsn = "$dbms:host=$host;dbname=$dbName";
        if (!isset($link)) {
            try {
                self::$link = new \PDO($dsn, $user, $pass); //初始化一个PDO对象
            }
            catch(PDOException $e) {
                die("Error!: " . $e->getMessage() . "<br/>");
            }
            if (!self::$link) {
                self::throw_excption("PDO链接错误");
                return false;
            }
            self::$link->exec("SET NAMES " . $mysqlConfig["charset"]); // 设置编码
            self::$connected = true;
            unset($mysqlConfig);
        }
    }
    // 自定义错误处理
    public static function thro_excption($errMsg) {
        echo '<span style="color:#f00">' . $errMsg . '</span>';
    }
    // 得到所有记录--------------------------------------------------
    public static function getAll($sql = "", $arg) {
        if ($sql != "") {
            self::query($sql, $arg);
        }
        $result = self::$PDOStatement->fetchAll(constant("PDO::FETCH_ASSOC")); // 设置结果级为关联数组
        return $result;
    }
    // 得到一条记录-----------------------------------------------------
    public static function getRow($sql = "", $arg) {
        if ($sql != "") {
            self::query($sql, $arg);
        }
        $result = self::$PDOStatement->fetch(constant("PDO::FETCH_ASSOC")); // 设置结果级为关联数组
        return $result;
    }
    // 得到记录数量-----------------------------------------------------
    public static function getNum($sql = "", $arg) {
        if ($sql != "") {
            self::query($sql, $arg);
        }
        $result = self::$PDOStatement->fetchAll(constant("PDO::FETCH_ASSOC")); // 设置结果级为关联数组
        return count($result);
    }
    // 增，删，改操作  返回受影响的条数-------------------------------------------
    public static function execute($sql = "", $arg) {
        $link = self::$link;
        if (!$link) {
            return false;
        }
        // 判断之前是否有结果集，如果有，释放结果集
        if (!empty(self::$PDOStatement)) {
            self::free();
        }
        self::$queryStr = $sql;
        self::$PDOStatement = $link->prepare(self::$queryStr); //准备一条语句  参数用？占位符，防止注入
        $result = self::$PDOStatement->execute($arg); //传入参数 执行语句
        self::haveErr();
        if ($result) {
            self::$lastInsertId = $link->lastInsertId();
            self::$numRows = $result;
            return 1;
        } else {
            return 0;
        }
    }
    // 用户执行查询语句
    public static function query($sql = "", $arg) {
        $link = self::$link;
        if (!$link) {
            return false;
        }
        // 判断之前是否有结果集，如果有，释放结果集
        if (!empty(self::$PDOStatement)) {
            self::free();
        }
        self::$queryStr = $sql;
        self::$PDOStatement = $link->prepare(self::$queryStr); //准备一条语句  参数用？占位符，防止注入
        $res = self::$PDOStatement->execute($arg); //传入参数 执行语句
        self::haveErr();
        return $res;
    }
    // 查询是否有错误
    public static function haveErr() {
        if (empty(self::$PDOStatement)) {
            $obj = self::$link;
        } else {
            $obj = self::$PDOStatement;
        }
        $arrError = $obj->errorInfo();
        if ($arrError[0] != "00000") {
            self::$errInfo = "errInfo:" . $arrError[2] . " sql:" . self::$queryStr;
            self::thro_excption(self::$errInfo);
            return false;
        }
    }
    // 释放结果集
    public static function free() {
        self::$PDOStatement = null;
    }
}
?>