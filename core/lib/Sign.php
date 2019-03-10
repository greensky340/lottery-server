<?php
namespace core\lib;
class Sign{
  public function __construct(){
  }
  static function md5($str){
    $result = md5($str);
    return $result;
  }
  //  用私钥生成加密串
  static function pri_sign($data,$private_key){
    $private_key=str_replace("-----BEGIN RSA PRIVATE KEY-----","",$private_key);
    $private_key=str_replace("-----END RSA PRIVATE KEY-----","",$private_key);
    $private_key=str_replace("\n","",$private_key);
    $private_key='-----BEGIN RSA PRIVATE KEY-----'.PHP_EOL.wordwrap($private_key, 64, "\n", true) .PHP_EOL.'-----END RSA PRIVATE KEY-----';
    $res = openssl_pkey_get_private($private_key);
    if (openssl_sign($data, $content, $res))  //base64编码后的签名
      return base64_encode($content);
    }
  // ras2验签 利用公钥做验证
  static function rsaVerify($prestr,$sign,$pubKey) {
    //以下为了初始化私钥，保证在您填写私钥时不管是带格式还是不带格式都可以通过验证。
    $pubKey=str_replace("-----BEGIN PUBLIC KEY-----","",$pubKey);
    $pubKey=str_replace("-----END PUBLIC KEY-----","",$pubKey);
    $pubKey=str_replace("\n","",$pubKey);
    $pubKey='-----BEGIN PUBLIC KEY-----'.PHP_EOL.wordwrap($pubKey, 64, "\n", true) .PHP_EOL.'-----END PUBLIC KEY-----';
    $res=openssl_get_publickey($pubKey);
    if ($res) {
      $verify=openssl_verify($prestr, base64_decode($sign), $res, OPENSSL_ALGO_SHA256);
      openssl_free_key($res);
    }
    return $verify;
  }
}
?>