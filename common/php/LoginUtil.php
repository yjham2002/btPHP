<? include $_SERVER[DOCUMENT_ROOT] . "/common/classes/comm/Constants.php" ?>
<?php
/*
 * Created on 2006. 09. 25
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
if (!class_exists("LoginUtil")) {
    class LoginUtil
    {

        public static $spliter = 30;        // Seperator Ascii code

        static function getAdminUser()
        {
            $cookieStr = $_COOKIE["admMap"];
            if (LoginUtil::isAdminLogin() == false) {
                $map = null;
            }
            else {
                $cookieStr = pack("H*", $cookieStr);
                $map = json_decode($cookieStr);
            }
            return $map;
        }

        // 로그인 유무
        static function isAdminLogin()
        {
            $cookieStr = $_COOKIE["admMap"];
            return ($cookieStr != "") ? true : false;
        }

        //관리자 로그인
        static function doAdminLogin($row){
            if ($row != null) {
                $cookieStr = json_encode($row);
                $cookieStr = bin2hex($cookieStr); // 16진수로 암호화
                setcookie("admMap", $cookieStr, -1, "/", "");
                return true;
            } else {
                return false;
            }
        }

        //admin 로그아웃
        static function doAdminLogout()
        {
            setcookie("admMap", "", time() - 3600, "/", "");
        }


        //입력 후 로그인 - APP 로그인
        static function doAppLogin($row)
        {

            if ($row != null) {
                $cookieStr =

                    $row['user_no'] . chr(30) .
                    $row['email'] . chr(30) .
                    $row['fb_id'] . chr(30) .
                    $row['user_name'] . chr(30) .
                    $row['user_type'] . chr(30) .
                    $row['user_group'] . chr(30) .
                    $row['regist_dt'] . chr(30) .
                    $row['appVersion'] . chr(30) .
                    $row['storeTypeID'] . chr(30);

                $cookieStr = bin2hex($cookieStr); // 16진수로 암호화

                //setcookie("userMap",$cookieStr,-1,"/", '.richware.co.kr') ;
                setcookie("userMap", $cookieStr, -1, "/", '');

                return true;

            } else {

                return false;
            }
        }


        // 어플 로그인 여부를 확인한다.
        static function isAppLogin()
        {
            $cookieStr = $_COOKIE["userMap"];

            $cookieStr = pack("H*", $cookieStr);

            $aUser = explode(chr(30), $cookieStr);

            return ($aUser[0] != "" && $aUser[0] != "-1") ? true : false;
        }


        static function doAppLogout()
        {
            setcookie("userMap", "", time() - 3600, "/", "");
        }

        static function getAppUser()
        {
            $cookieStr = $_COOKIE["userMap"];

            $cookieStr = pack("H*", $cookieStr);

            $aUser = explode(chr(30), $cookieStr);

            $map['user_no'] = $aUser[0];
            $map['email'] = $aUser[1];
            $map['fb_id'] = $aUser[2];
            $map['user_name'] = $aUser[3];
            $map['user_type'] = $aUser[4];
            $map['user_group'] = $aUser[5];
            $map['regist_dt'] = $aUser[6];
            $map['appVersion'] = $aUser[7];
            $map['storeTypeID'] = $aUser[8];

            if (LoginUtil::isAppLogin() == false) {
                $map['user_no'] = "-1";
            }

            return $map;
        }

        static function doWebLogin($row){
            if ($row != null) {
                $cookieStr = json_encode($row);
                $cookieStr = bin2hex($cookieStr); // 16진수로 암호화
                setcookie("webUserMap", $cookieStr, -1, "/", "");
                return true;
            } else {
                return false;
            }
        }

        // 로그인 유무
        static function isWebLogin(){
            $cookieStr = $_COOKIE["webUserMap"];
            return ($cookieStr != "") ? true : false;
        }

        static function getWebUser(){
            $cookieStr = $_COOKIE["webUserMap"];
            if (LoginUtil::isWebLogin() == false) {
                $map = null;
            }
            else {
                $cookieStr = pack("H*", $cookieStr);
                $map = json_decode($cookieStr);
            }
            return $map;
        }

        static function doWebLogout(){
            setcookie("webUserMap", "", time() - 3600, "/", "");
        }
    }
}
?>