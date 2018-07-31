<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebBase.php" ;?>
<?php
if(! class_exists("WebUser") ){

    class WebUser extends Common{
        function __construct($req){
            parent::__construct($req);
        }

        function logOut(){
            LoginUtil::doWebLogout();
            return;
        }

        function updatePushKey(){
            $retVal = $this->get("/web/user/update/pushKey/{$this->webUser->id}", Array("pushKey" => $_REQUEST["pushKey"]));
            return $retVal;
        }

        function autoLogin(){
            $retVal = $this->get("/web/user/basic/{$_REQUEST["userId"]}", null);
            LoginUtil::doWebLogin(json_decode($retVal)->data);
            return $retVal;
        }

        function userLogin(){
            $retVal = $this->post("/web/user/login", Array("account" => $_REQUEST["account"], "password" => $_REQUEST["password"] ));
            LoginUtil::doWebLogin(json_decode($retVal)->data);
            return $retVal;
        }

        function checkAccountDuplication(){
            $retVal = $this->get("/web/user/checkAccountDuplication/{$_REQUEST["account"]}", null);
            return $retVal;
        }

        function checkPhoneDuplication(){
            $retVal = $this->get("/web/user/checkPhoneDuplication/{$_REQUEST["phone"]}", null);
            return $retVal;
        }

        function sendAuth(){
            $retVal = $this->get("/web/user/auth/{$_REQUEST["phone"]}", null);
            return $retVal;
        }

        function verifyCode(){
            $retVal = $this->get("/web/user/verify/{$_REQUEST["phone"]}", Array("code" => $_REQUEST["code"]));
            return $retVal;
        }

        function getSidoList(){
            $retVal = $this->get("/info/region", null);
            return $retVal;
        }

        function getGugunList(){
            $retVal = $this->get("/info/region/{$_REQUEST["sidoID"]}", null);
            return $retVal;
        }

        function getWorkInfo(){
            $retVal = $this->get("/info/work", Array("work" => $_REQUEST["work"]));
            return $retVal;
        }

        function joinUser(){
            $gearInfo = stripslashes($_REQUEST["gearInfo"]);
            $retVal = $this->post("/web/user/join", Array("name" => $_REQUEST["name"], "account" => $_REQUEST["account"],
                "password" => $_REQUEST["password"], "phone" => $_REQUEST["phone"], "age" => $_REQUEST["age"], "type" => $_REQUEST["type"],
                "pushKey" => $_REQUEST["pushKey"], "region" => $_REQUEST["regionArr"], "work" => $_REQUEST["workArr"],
                "career" => $_REQUEST["careerArr"], "welderType" => $_REQUEST["welderType"], "gearInfo" => $gearInfo,
                "sex" => $_REQUEST["sex"]));


            LoginUtil::doWebLogin(json_decode($retVal)->data);
            return $retVal;
        }

        function getGearOption1(){
            $retVal = $this->get("/info/gearOption1", Array("name" => $_REQUEST["name"]));
            return $retVal;
        }

        function getGearOption2(){
            $retVal = $this->get("/info/gearOption2", Array("name" => $_REQUEST["name"], "detail" => $_REQUEST["detail"]));
            return $retVal;
        }

        function getGearInfo(){
            $retVal = $this->get("/info/gear/{$_REQUEST["gearId"]}", null);
            return $retVal;
        }

        function registerSearch(){
            $retVal = $this->post("/web/register/search/{$this->webUser->id}", Array("type" => $_REQUEST["type"], "work" => $_REQUEST["workArr"],
                "career" => $_REQUEST["careerArr"], "welderType" => $_REQUEST["welderType"], "sidoId" => $_REQUEST["sidoId"],
                "gugunId" => $_REQUEST["gugunId"], "name" => $_REQUEST["name"], "startDate" => $_REQUEST["startDate"], "endDate" => $_REQUEST["endDate"],
                "lodging" => $_REQUEST["lodging"], "price" => $_REQUEST["price"], "discussLater" => $_REQUEST["discussLater"], "gearId" => $_REQUEST["gearId"],
                "attachment" => $_REQUEST["attachment"]));
            return $retVal;
        }

        function getUserInfo(){
            $retVal = $this->get("/web/user/info/{$this->webUser->id}", null);
            return $retVal;
        }

        function getUserRegion(){
            $retVal = $this->get("/web/user/region/{$this->webUser->id}", null);
            return $retVal;
        }

        function updateUserInfo(){
            $retVal = $this->post("/web/user/update/info/{$this->webUser->id}", Array("type" => $_REQUEST["type"], "region" => $_REQUEST["regionArr"],
                "work" => $_REQUEST["workArr"], "career" => $_REQUEST["careerArr"], "welderType" => $_REQUEST["welderType"], "gearInfo" => stripslashes($_REQUEST["gearInfo"])));
            return $retVal;
        }

        function updateUserName(){
            $retVal = $this->post("/web/user/update/name/{$this->webUser->id}", Array("name" => $_REQUEST["name"]));
            LoginUtil::doWebLogin(json_decode($retVal)->data);
            return $retVal;
        }

        function updatePushFlag(){
            if($this->webUser->pushFlag  == 1)
                $result = $this->post("/web/user/push/off/{$this->webUser->id}", null);
            else
                $result = $this->post("/web/user/push/on/{$this->webUser->id}", null);
            LoginUtil::doWebLogin(json_decode($result)->data);
            return $result;
        }

        function withdrawUser(){
            $retVal = $this->post("/web/user/withdraw/{$this->webUser->id}", null);
            LoginUtil::doWebLogout();
            return $retVal;
        }

        function findID(){
            $retVal = $this->get("/web/user/findID", Array("name" => $_REQUEST["name"], "phone" => $_REQUEST["phone"]));
            return $retVal;
        }

        function findPW(){
            $retVal = $this->get("/web/user/findPW", Array("name" => $_REQUEST["name"], "phone" => $_REQUEST["phone"], "account" => $_REQUEST["account"]));
            return $retVal;
        }

        function changePW(){
            $retVal = $this->post("/web/user/changePW/{$_REQUEST["id"]}", Array("password" => $_REQUEST["password"]));
            return $retVal;
        }

        function updateUserImg(){
            $retVal = $this->post("/web/user/updateImg/{$this->webUser->id}", Array("imgPath" => $_REQUEST["imgPath"]));
            LoginUtil::doWebLogin(json_decode($retVal)->data);
            return $retVal;
        }

        function getUserPoint(){
            $retVal = $this->get("/web/user/point/{$this->webUser->id}", null);
            return $retVal;
        }

        function getPointHistory(){
            $retVal = $this->get("/web/user/paid/{$this->webUser->id}", null);
//            $retVal = $this->get("/web/user/myApplyList/{$this->webUser->id}", null);
//            $retVal = $this->get("/web/user/pointList/{$this->webUser->id}", null);
            return $retVal;
        }

        function hideApplyList(){
            $retVal = $this->post("/web/user/paid/del/{$_REQUEST["id"]}", null);
//            $retVal = $this->post("/web/user/apply/del/{$_REQUEST["id"]}", null);
            return $retVal;
        }

//        function hidePointHistory(){
//            $retVal = $this->post("/web/user/point/del/{$_REQUEST["id"]}", null);
//            return $retVal;
//        }

        function getApplicationList(){
            $retVal = $this->get("/web/user/applications/{$this->webUser->id}", null);
            return $retVal;
        }

        function usePoint(){
            $retVal = $this->post("/web/user/point/use/{$this->webUser->id}", null);
            return $retVal;
        }

        function insertPaymentBasic(){
            $userId = $_REQUEST["userId"];

            $sql = "
                INSERT INTO tblPayment(`userId`, `regDate`)
                VALUES(
                  '{$userId}',
                  NOW()
                )
            ";

            $this->update($sql);

            $lastId = $this->mysql_insert_id();
            return $lastId;
        }

        function deleteImg(){
            $sql = "
                UPDATE tblUser
                SET imgPath = ''
                WHERE `id` = '{$_REQUEST["id"]}' 
            ";

            $this->update($sql);
            return $this->makeResultJson(1, "succ");
        }

        function updatePhone(){
            $sql = "
                UPDATE tblUser
                set phone = '{$_REQUEST["phone"]}'
                WHERE `id` = '{$_REQUEST["id"]}'
            ";

            $this->update($sql);
            return $this->makeResultJson(1, "succ");
        }

    }
}
?>