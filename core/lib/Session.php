<?php
namespace core\lib;
class Session
{
    static function Session()
    {
        session_start();
    }
 
    static function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }
 
    static function get($name)
    {
        if(isset($_SESSION[$name]))
            return $_SESSION[$name];
        else
            return false;
    }
 
    static function del($name)
    {
        unset($_SESSION[$name]);
    }
 
    static function destroy()
    {
        $_SESSION = array();
        session_destroy();
    }
}
?>