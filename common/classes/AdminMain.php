<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminBase.php" ;?>
<?
/*
 * Web process
 * add by cho
 * */
if(!class_exists("AdminMain")){
    class AdminMain extends  AdminBase {
        function __construct($req)
        {
            parent::__construct($req);
        }

        function login(){
            $account = $_REQUEST["account"];
            $password = md5($_REQUEST["password"]);

            $sql = "
                SELECT * FROM tblAdmin
                WHERE `account` = '{$account}' AND `password` = '{$password}' AND status = 1
                LIMIT 1
            ";
            $res = $this->getRow($sql);
            if($res != ""){
                LoginUtil::doAdminLogin($res);
                return $this->makeResultJson(1, "succ", $res);
            }
            else return $this->makeResultJson(-1, "fail");
        }

        function logout(){
            LoginUtil::doAdminLogout();
            return $this->makeResultJson(1, "succ");
        }

        function adminList(){
            $sql = "
                SELECT * FROM tblAdmin
                WHERE status = 1
                ORDER BY regDate DESC
            ";

            return $this->getArray($sql);
        }

        function adminInfo(){
            $id = $_REQUEST["id"];
            $sql = "SELECT * FROM tblAdmin WHERE adminNo = '{$id}' AND status = 1";
            return $this->getRow($sql);
        }

        function manageAdminAccount(){
            $currentId = $this->admUser->adminNo;

            $id = $_REQUEST["id"];
            $name = $_REQUEST["adminName"];
            $phone = $_REQUEST["adminPhone"];
            $account = $_REQUEST["adminID"];
            $pwd = md5($_REQUEST["adminPwd"]);

            if($id == ""){
                $sql = "
                    INSERT INTO tblAdmin(adminName, adminPhone, adminID, adminPwd, regDate, status)
                    VALUES(
                      '{$name}',
                      '{$phone}',
                      '{$account}',
                      '{$pwd}',
                      NOW(),
                      1
                    )
                ";
            }
            else{
                $sql = "
                    UPDATE tblAdmin 
                    SET
                      adminName = '{$name}',
                      adminPhone = '{$phone}',
                      adminID = '{$account}'
                    WHERE adminNo = {$id}
                ";

                if($pwd != ""){
                    $tmp = "UPDATE tblAdmin SET adminPwd = '{$pwd}' WHERE adminNo = {$id}";
                    $this->update($tmp);
                }
            }
            $this->update($sql);

            if($currentId == $id){
                //조작한 정보가 현재 로그인 되어있는 계정일 시 쿠키 수정
                $sql = "SELECT * FROM tblAdmin WHERE adminNo = {$id}";
                LoginUtil::doAdminLogin($this->getRow($sql));
            }

            return $this->makeResultJson(1, "succ");
        }

        function deleteAdmin(){
            $noArr = $this->req["no"];

            $noStr = implode(',', $noArr);

            $sql = "
				UPDATE tblAdmin
				SET status = 0
				WHERE `adminNo` IN({$noStr})
			";
            $this->update($sql);

            return $this->makeResultJson(1, "succ");
        }

        function getAppList(){
            $sql = "
                SELECT * FROM tblApps
                ORDER BY regDate DESC
            ";
            return $this->getArray($sql);
        }

        function deleteApp(){
            $appId = $_REQUEST["appId"];
            $sql = "DELETE FROM tblApps WHERE id = '{$appId}'";
            $this->update($sql);
            return $this->makeResultJson(1, "succ");
        }

        function updateApp(){
            $appId = $_REQUEST["appId"];
            $sql = "UPDATE tblApps SET version = version + 1 WHERE `id` = '{$appId}'";
            $this->update($sql);
            return $this->makeResultJson(1, "succ");
        }

        function manageApp(){
            $appId = $_REQUEST["appId"];

            $appName = $_REQUEST["appName"];
            $appDesc = $_REQUEST["appDesc"];

            if($appId == ""){
                $sql = "
                INSERT INTO tblApps(appName, appDesc, uptDate, regDate)
                VALUES(
                  '{$appName}',
                  '{$appDesc}',
                  NOW(),
                  NOW()
                )
            ";
                $this->update($sql);
            }
            else{
                $sql = "
                    UPDATE tblApps
                    SET
                      `appName` = '{$appName}',
                      `appDesc` = '{$appDesc}',
                      `uptDate` = NOW()
                    WHERE `id` = '{$appId}'
                ";
                $this->update($sql);
            }
            return $this->makeResultJson(1, "succ");
        }

        function recommendList(){
            $appId = $_REQUEST["appId"];

            $sql = "
                SELECT * FROM tblRecommend
                WHERE appId = {$appId}
                ORDER by `order` ASC
            ";

            return $this->getArray($sql);
        }

        function appInfo(){
            $appId = $_REQUEST["appId"];
            $sql = "
                SELECT * FROM tblApps WHERE `id` = '{$appId}' LIMIT 1
            ";
            return $this->getRow($sql);
        }

        function recommendDetail(){
            $appId = $_REQUEST["appId"];
            $id = $_REQUEST["id"];

            $sql = "
                SELECT * FROM tblRecommend
                WHERE `appId` = '{$appId}' AND `id` = '{$id}'
                LIMIT 1
            ";
            return $this->getRow($sql);
        }

        function changeRecommendOrder(){
            $type = $_REQUEST["type"];
            $id = $_REQUEST["id"];

            $sql = "SELECT * FROM tblRecommend WHERE `id` = {$id}";
            $currentRow = $this->getRow($sql);

            if($type == -1){
                $sql = "SELECT * FROM tblRecommend WHERE `order` > {$currentRow["order"]} ORDER BY `order` ASC LIMIT 1";
                $upperRow = $this->getRow($sql);
                if($upperRow == "") return $this->makeResultJson(-1, "fail");
                else{
                    $sql = "
                        UPDATE tblRecommend
                        SET `order` = {$currentRow["order"]}
                        WHERE `id` = (SELECT * FROM (SELECT id FROM tblRecommend WHERE `order` > {$currentRow["order"]} ORDER BY `order` ASC LIMIT 1) tmp)
                    ";
                    $this->update($sql);

                    $sql = "
                        UPDATE tblRecommend
                        SET `order` = {$upperRow["order"]}
                        WHERE `id` = {$id}
                    ";
                    $this->update($sql);
                    return $this->makeResultJson(1, "succ");
                }
            }
            else if($type == 1){
                $sql = "SELECT * FROM tblRecommend WHERE `order` < {$currentRow["order"]} ORDER BY `order` DESC LIMIT 1";
                $lowerRow = $this->getRow($sql);
                if($lowerRow == "") return $this->makeResultJson(-2, "fail");
                else{
                    $sql = "
                        UPDATE tblRecommend
                        SET `order` = {$currentRow["order"]}
                        WHERE `id` = (SELECT * FROM (SELECT id FROM tblRecommend WHERE `order` < {$currentRow["order"]} ORDER BY `order` DESC LIMIT 1) tmp)
                    ";
                    $this->update($sql);

                    $sql = "
                        UPDATE tblRecommend
                        SET `order` = {$lowerRow["order"]}
                        WHERE `id` = {$id}
                    ";
                    $this->update($sql);
                    return $this->makeResultJson(1, "succ");
                }
            }
            else{
                return $this->makeResultJson(-3, "fail");
            }
        }

        function deleteRecommend(){
            $noArr = $this->req["no"];
            $noStr = implode(',', $noArr);
            $sql = "DELETE FROM tblRecommend WHERE `id` IN ({$noStr})";
            $this->update($sql);
            return $this->makeResultJson(1, "succ");
        }

        function exactTime(){
            $t = explode(' ',microtime());
            return floor(($t[0] + $t[1])*1000);

        }

        function makeFileName(){
            srand((double)microtime()*1000000) ;
            $Rnd = rand(1000000,2000000) ;
            $Temp = date("Ymdhis") ;
            return $Temp.$Rnd;

        }
        function manageRecommend(){
            $check = getimagesize($_FILES["imgFile"]["tmp_name"]);
            $appId = $_REQUEST["appId"];
            $id = $_REQUEST["id"];
            $appName = $_REQUEST["appName"];
            $appDesc = $_REQUEST["appDesc"];
            $packageName = $_REQUEST["packageName"];
            $exposure = $_REQUEST["exposure"] == "" ? 0 : $_REQUEST["exposure"];
            $imgPath = NULL;

            if($id == ""){
                if($check !== false){
                    $name = $this->makeFileName() . "." . pathinfo(basename($_FILES["imgFile"]["name"]),PATHINFO_EXTENSION);
                    $targetDir = $this->filePath . $name;
                    if(move_uploaded_file($_FILES["imgFile"]["tmp_name"], $targetDir)) $imgPath = $name;
                    else return $this->makeResultJson(-1, "fail");
                }
                $sql = "SELECT `order` FROM tblRecommend WHERE appId = '{$appId}' ORDER BY `order` DESC LIMIT 1";
                $order = $this->getValue($sql, "order");
                $order++;

                $sql = "
                        INSERT INTO tblRecommend(`appId`, `appName`, `appDesc`, `order`, `packageName`, `exposure`, `imgPath`, `uptDate`, `regDate`)
                        VALUES(
                          '{$appId}',
                          '{$appName}',
                          '{$appDesc}',
                          '{$order}',
                          '{$packageName}',
                          '{$exposure}',
                          '{$imgPath}',
                          NOW(),
                          NOW()
                        )
                    ";
                $this->update($sql);
            }
            else{
                $imgPath = $_REQUEST["imgPath"];
                if($check !== false){
                    //data with img
                    $name = $this->makeFileName() . "." . pathinfo(basename($_FILES["imgFile"]["name"]),PATHINFO_EXTENSION);
                    $targetDir = $this->filePath . $name;
                    if(move_uploaded_file($_FILES["imgFile"]["tmp_name"], $targetDir)) $imgPath = $name;
                    else return $this->makeResultJson(-1, "fail");
                }
                $sql = "
                    UPDATE tblRecommend
                    SET
                      `appName` = '{$appName}',
                      `appDesc` = '{$appDesc}',
                      `packageName` = '{$packageName}',
                      `exposure` = '{$exposure}',
                      `imgPath` = '{$imgPath}',
                      `uptDate` = NOW()
                    WHERE `id` = {$id} AND `appId` = {$appId}
                ";
                $this->update($sql);
            }
            return $this->makeResultJson(1, "succ");
        }

        function stageList(){
            $appId = $_REQUEST["appId"];

            $sql = "
                SELECT * FROM tblStage
                WHERE appId = {$appId}
                ORDER by `order` ASC
            ";

            return $this->getArray($sql);
        }

        function stageDetail(){
            $appId = $_REQUEST["appId"];
            $id = $_REQUEST["stageId"];

            $sql = "
                SELECT * FROM tblStage
                WHERE `appId` = '{$appId}' AND `id` = '{$id}'
                LIMIT 1
            ";

            return $this->getRow($sql);
        }

        function changeStageOrder(){
            $type = $_REQUEST["type"];
            $id = $_REQUEST["id"];

            $sql = "SELECT * FROM tblStage WHERE `id` = {$id}";
            $currentRow = $this->getRow($sql);

            if($type == -1){
                $sql = "SELECT * FROM tblStage WHERE `order` > {$currentRow["order"]} ORDER BY `order` ASC LIMIT 1";
                $upperRow = $this->getRow($sql);
                if($upperRow == "") return $this->makeResultJson(-1, "fail");
                else{
                    $sql = "
                        UPDATE tblStage
                        SET `order` = {$currentRow["order"]}
                        WHERE `id` = (SELECT * FROM (SELECT id FROM tblStage WHERE `order` > {$currentRow["order"]} ORDER BY `order` ASC LIMIT 1) tmp)
                    ";
                    $this->update($sql);

                    $sql = "
                        UPDATE tblStage
                        SET `order` = {$upperRow["order"]}
                        WHERE `id` = {$id}
                    ";
                    $this->update($sql);
                    return $this->makeResultJson(1, "succ");
                }
            }
            else if($type == 1){
                $sql = "SELECT * FROM tblStage WHERE `order` < {$currentRow["order"]} ORDER BY `order` DESC LIMIT 1";
                $lowerRow = $this->getRow($sql);
                if($lowerRow == "") return $this->makeResultJson(-2, "fail");
                else{
                    $sql = "
                        UPDATE tblStage
                        SET `order` = {$currentRow["order"]}
                        WHERE `id` = (SELECT * FROM (SELECT id FROM tblStage WHERE `order` < {$currentRow["order"]} ORDER BY `order` DESC LIMIT 1) tmp)
                    ";
                    $this->update($sql);

                    $sql = "
                        UPDATE tblStage
                        SET `order` = {$lowerRow["order"]}
                        WHERE `id` = {$id}
                    ";
                    $this->update($sql);
                    return $this->makeResultJson(1, "succ");
                }
            }
            else{
                return $this->makeResultJson(-3, "fail");
            }
        }

        function deleteStage(){
            $noArr = $this->req["no"];
            $noStr = implode(',', $noArr);
            $sql = "DELETE FROM tblStage WHERE `id` IN ({$noStr})";
            $this->update($sql);
            return $this->makeResultJson(1, "succ");
        }

        function manageStage(){
            $check = getimagesize($_FILES["imgFile"]["tmp_name"]);
            $appId = $_REQUEST["appId"];
            $id = $_REQUEST["id"];
            $stageDesc = $_REQUEST["stageDesc"];

            $imgPath = NULL;

            if($id == ""){
                if($check !== false){
                    $name = $this->makeFileName() . "." . pathinfo(basename($_FILES["imgFile"]["name"]),PATHINFO_EXTENSION);
                    $targetDir = $this->filePath . $name;
                    if(move_uploaded_file($_FILES["imgFile"]["tmp_name"], $targetDir)) $imgPath = $name;
                    else return $this->makeResultJson(-1, "fail");
                }
                $sql = "SELECT `order` FROM tblStage WHERE appId = '{$appId}' ORDER BY `order` DESC LIMIT 1";
                $order = $this->getValue($sql, "order");
                $order++;

                $sql = "
                    INSERT INTO tblStage(`appId`, `stageDesc`, `order`, `originalPath`, `uptDate`, `regDate`)
                    VALUES(
                      '{$appId}',
                      '{$stageDesc}',
                      '{$order}',
                      '{$imgPath}',
                      NOW(),
                      NOW()
                    )
                ";
                $this->update($sql);
            }
            else{
                $imgPath = $_REQUEST["originalPath"];
                if($check !== false){
                    //data with img
                    $name = $this->makeFileName() . "." . pathinfo(basename($_FILES["imgFile"]["name"]),PATHINFO_EXTENSION);
                    $targetDir = $this->filePath . $name;
                    if(move_uploaded_file($_FILES["imgFile"]["tmp_name"], $targetDir)) $imgPath = $name;
                    else return $this->makeResultJson(-1, "fail");
                }
                $sql = "
                    UPDATE tblStage
                    SET
                      `stageDesc` = '{$stageDesc}',
                      `originalPath` = '{$imgPath}',
                      `uptDate` = NOW()
                    WHERE `id` = {$id} AND `appId` = {$appId}
                ";
                $this->update($sql);
            }
            return $this->makeResultJson(1, "succ");
        }

        function questionList(){
            $stageId = $_REQUEST["stageId"];
            $sql = "SELECT * FROM tblQuestion WHERE stageId = '{$stageId}' ORDER BY uptDate DESC";
            return $this->getArray($sql);
        }

        function deleteQuestion(){
            $noArr = $this->req["no"];
            $noStr = implode(',', $noArr);
            $sql = "DELETE FROM tblQuestion WHERE `id` IN ({$noStr})";
            $this->update($sql);
            $sql = "DELETE FROM tblAnswer WHERE `questionId` IN ({$noStr})";
            $this->update($sql);
            return $this->makeResultJson(1, "succ");
        }

        function questionDetail(){
            $id = $_REQUEST["id"];
            $sql = "SELECT * FROM tblQuestion WHERE `id` = '{$id}' LIMIT 1";
            return $this->getRow($sql);
        }

        function answerList(){
            $id = $_REQUEST["id"];
            $sql = "SELECT * FROM tblAnswer WHERE questionId = '{$id}' ORDER BY `id` ASC";
            return $this->getArray($sql);
        }

        //TODO
        function manageQuestion(){
            $check = getimagesize($_FILES["imgFile"]["tmp_name"]);
            $appId = $_REQUEST["appId"];
            $id = $_REQUEST["id"];
            $stageDesc = $_REQUEST["stageDesc"];

            $imgPath = NULL;

            if($id == ""){
                if($check !== false){
                    $name = $this->makeFileName() . "." . pathinfo(basename($_FILES["imgFile"]["name"]),PATHINFO_EXTENSION);
                    $targetDir = $this->filePath . $name;
                    if(move_uploaded_file($_FILES["imgFile"]["tmp_name"], $targetDir)) $imgPath = $name;
                    else return $this->makeResultJson(-1, "fail");
                }
                $sql = "SELECT `order` FROM tblStage WHERE appId = '{$appId}' ORDER BY `order` DESC LIMIT 1";
                $order = $this->getValue($sql, "order");
                $order++;

                $sql = "
                    INSERT INTO tblStage(`appId`, `stageDesc`, `order`, `originalPath`, `uptDate`, `regDate`)
                    VALUES(
                      '{$appId}',
                      '{$stageDesc}',
                      '{$order}',
                      '{$imgPath}',
                      NOW(),
                      NOW()
                    )
                ";
                $this->update($sql);
            }
            else{
                $imgPath = $_REQUEST["originalPath"];
                if($check !== false){
                    //data with img
                    $name = $this->makeFileName() . "." . pathinfo(basename($_FILES["imgFile"]["name"]),PATHINFO_EXTENSION);
                    $targetDir = $this->filePath . $name;
                    if(move_uploaded_file($_FILES["imgFile"]["tmp_name"], $targetDir)) $imgPath = $name;
                    else return $this->makeResultJson(-1, "fail");
                }
                $sql = "
                    UPDATE tblStage
                    SET
                      `stageDesc` = '{$stageDesc}',
                      `originalPath` = '{$imgPath}',
                      `uptDate` = NOW()
                    WHERE `id` = {$id} AND `appId` = {$appId}
                ";
                $this->update($sql);
            }
            return $this->makeResultJson(1, "succ");
        }

//        function addAnswer(){
//            $id = $_REQUEST["id"];
//            $x = $_REQUEST["x"];
//            $y = $_REQUEST["y"];
//            $threshold = $_REQUEST["threshold"];
//
//            $sql = "
//                INSERT INTO tblAnswer(`questionId`, `coordX`, `coordY`, `threshold`)
//                VALUES(
//                  '{$id}',
//                  '{$x}',
//                  '{$y}',
//                  '{$threshold}'
//                )
//            ";
//            $this->update($sql);
//            return $this->makeResultJson(1, "succ");
//        }
//
//        function deleteAnswer(){
//            $noArr = $this->req["no"];
//            $noStr = implode(',', $noArr);
//            $sql = "DELETE FROM tblAnswer WHERE `id` IN ({$noStr})";
//            $this->update($sql);
//            return $this->makeResultJson(1, "succ");
//        }

        function manageAnswer(){
            $check = false;
            if(isset($_FILES["imgFile"]))
                $check = getimagesize($_FILES["imgFile"]["tmp_name"]);

            $stageId = $_REQUEST["stageId"];
            $id = $_REQUEST["questionId"];
            $data = str_replace("\\", "", $_REQUEST["data"]);
            $data = json_decode($data);
            $imgPath = NULL;

            if($id == ""){
                if($check !== false){
                    $name = $this->makeFileName() . "." . pathinfo(basename($_FILES["imgFile"]["name"]),PATHINFO_EXTENSION);
                    $targetDir = $this->filePath . $name;
                    if(move_uploaded_file($_FILES["imgFile"]["tmp_name"], $targetDir)) $imgPath = $name;
                    else return $this->makeResultJson(-1, "fail");
                }

                $sql = "
                    INSERT INTO tblQuestion(`stageId`, `imgPath`,`uptDate`, `regDate`)
                    VALUES(
                      '{$stageId}',
                      '{$imgPath}',
                      NOW(),
                      NOW()
                    )        
                 ";
                $this->update($sql);

                $lastId = $this->mysql_insert_id();
                foreach($data as $item){
                    $sql = "
                        INSERT INTO tblAnswer(`questionId`, `coordX`, `coordY`, threshold)
                        VALUES(
                          '{$lastId}',
                          '{$item->x}',
                          '{$item->y}',
                          '0.1'
                        )
                    ";
                    $this->update($sql);
                }
            }
            else{
                $imgPath = $_REQUEST["imgPath"];
                if($check !== false){
                    //data with img
                    $name = $this->makeFileName() . "." . pathinfo(basename($_FILES["imgFile"]["name"]),PATHINFO_EXTENSION);
                    $targetDir = $this->filePath . $name;
                    if(move_uploaded_file($_FILES["imgFile"]["tmp_name"], $targetDir)) $imgPath = $name;
                    else return $this->makeResultJson(-1, "fail");
                }

                $sql = "
                    UPDATE tblQuestion
                    SET 
                      `imgPath` = '{$imgPath}',
                      `uptDate` = NOW()
                    WHERE `id` = '{$id}'
                ";
                $this->update($sql);
                $sql = "DELETE FROM tblAnswer WHERE `questionId` = '{$id}'";
                $this->update($sql);
                foreach($data as $item){
                    $sql = "
                        INSERT INTO tblAnswer(`questionId`, `coordX`, `coordY`, `threshold`)
                        VALUES(
                          '{$id}',
                          '{$item->x}',
                          '{$item->y}',
                          '0.1'
                        )
                    ";
                    $this->update($sql);
                }
            }
            return $this->makeResultJson(1, "succ");
        }
    }
}