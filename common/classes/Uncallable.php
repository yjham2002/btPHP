<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminBase.php";?>
<?
if(!class_exists("Uncallable")){
    class Uncallable extends  AdminBase {

        function __construct($req){
            parent::__construct($req);
        }

        function deleteOrderForm(){
            $id = $_REQUEST["id"];
            $sql = "DELETE FROM tblOrderform WHERE `id`='{$id}'";
            $this->update($sql);
            return $this->makeResultJson(1, "succ");
        }

        function getOrderForm(){
            $id = $_REQUEST["id"];
            $sql = "SELECT * FROM tblOrderform WHERE `id`='{$id}'";
            return $this->getRow($sql);
        }

        function getOverviews(){
            $sql = "
            SELECT
            (SELECT COUNT(*) FROM tblCustomer) AS overview_user
            FROM DUAL
            ";
            return $this->getRow($sql);
        }

        function getNoticesForMain(){
            $sql = "
            SELECT
            ad.name, adn.adminId, adn.id, adn.title, adn.regDate
            FROM tblAdmin ad JOIN tblAdminNotification adn ON ad.id = adn.adminId
            ORDER BY adn.regDate DESC
            LIMIT 7
            ";
            return $this->getArray($sql);
        }

        function getDocList(){
            $this->initPage();
            $sqlNum = "SELECT COUNT(*) AS rn FROM tblDocument";
            $this->rownum = $this->getValue($sqlNum, "rn");
            $this->setPage($this->rownum);
            $sql = "
            SELECT
            ad.name, adn.adminId, adn.id, adn.title, adn.regDate, adn.filePath, adn.fileName
            FROM tblAdmin ad JOIN tblDocument adn ON ad.id = adn.adminId
            ORDER BY adn.regDate DESC
            LIMIT {$this->startNum}, {$this->endNum};
            ";
            return $this->getArray($sql);
        }

        function getReportList(){
            $this->initPage();
            $sqlNum = "SELECT COUNT(*) AS rn FROM tblReport";
            $this->rownum = $this->getValue($sqlNum, "rn");
            $this->setPage($this->rownum);
            $sql = "
            SELECT
            ad.name, adn.adminId, adn.id, adn.title, adn.regDate, 
            adn.filePath1, adn.fileName1,
            adn.filePath2, adn.fileName2,
            adn.filePath3, adn.fileName3,
            adn.filePath4, adn.fileName4,
            adn.filePath5, adn.fileName5
            FROM tblAdmin ad JOIN tblReport adn ON ad.id = adn.adminId
            ORDER BY adn.regDate DESC
            LIMIT {$this->startNum}, {$this->endNum};
            ";
            return $this->getArray($sql);
        }

        function getKakaoList(){
            $this->initPage();
            $where = " WHERE `state` = 1";

            $year = $_REQUEST["year"];
            $month = $_REQUEST["month"];
            $query = $_REQUEST["query"];
            $cls = $_REQUEST["cls"];

            if($_REQUEST["range"] == "1" && $month != "" && $year != "") {
                $yearNum = intval($year);
                $monthNum = intval($month);
                $where .= " AND YEAR(`regDate`) = '{$yearNum}' AND MONTH(`regDate`) = '{$monthNum}'";
            }

            if($query != ""){
                if($cls == "1"){
                    $where .= " AND `phone` LIKE '%{$query}%'";
                }else if($cls == "2"){
                    $where .= " AND `content` LIKE '%{$query}%'";
                }else{
                    $where .= " AND (`phone` LIKE '%{$query}%' OR `content` LIKE '%{$query}%')";
                }
            }

            $sqlNum = "SELECT COUNT(*) AS rn FROM tblKakaoLog {$where}";
            $this->rownum = $this->getValue($sqlNum, "rn");
            $this->setPage($this->rownum);
            $sql = "
            SELECT * FROM tblKakaoLog {$where}
            ORDER BY regDate DESC
            LIMIT {$this->startNum}, {$this->endNum};
            ";
            return $this->getArray($sql);
        }

        function getOrderFormList(){
            $this->initPage();
            $where = " WHERE 1=1 ";

            $yearS = $_REQUEST["yearS"];
            $monthS = $_REQUEST["monthS"];
            $yearE = $_REQUEST["yearE"];
            $monthE = $_REQUEST["monthE"];

            if($_REQUEST["range"] == "1" && $monthS != "" && $yearS != "" && $monthE != "" && $yearE != "") {
                $yearSNum = intval($yearS);
                $monthSNum = intval($monthS) < 10 ? "0".intval($monthS) : intval($monthS);
                $yearENum = intval($yearE);
                $monthENum = intval($monthE) < 10 ? "0".intval($monthE) : intval($monthE);
                $where .= " AND `regDate` BETWEEN DATE('{$yearSNum}-{$monthSNum}-01') AND LAST_DAY(DATE('{$yearENum}-{$monthENum}-01'))";
            }

            $sqlNum = "SELECT COUNT(*) AS rn FROM tblOrderform {$where}";
            $this->rownum = $this->getValue($sqlNum, "rn");
            $this->setPage($this->rownum);
            $sql = "
            SELECT 
                `id`, 
                `regNo`, 
                `buyer`, 
                `year`, 
                `month`, 
                `setDate`, 
                `type`,  
                `uptDate`, 
                `regDate`
            FROM tblOrderform {$where}
            ORDER BY regDate DESC
            LIMIT {$this->startNum}, {$this->endNum};
            ";
            return $this->getArray($sql);
        }

        function getNoticeList(){
            $this->initPage();
            $sqlNum = "SELECT COUNT(*) AS rn FROM tblAdminNotification";
            $this->rownum = $this->getValue($sqlNum, "rn");
            $this->setPage($this->rownum);
            $sql = "
            SELECT
            ad.name, adn.adminId, adn.id, adn.title, adn.regDate, adn.filePath, adn.fileName
            FROM tblAdmin ad JOIN tblAdminNotification adn ON ad.id = adn.adminId
            ORDER BY adn.regDate DESC
            LIMIT {$this->startNum}, {$this->endNum};
            ";
            return $this->getArray($sql);
        }

        function getDoc(){
            $id = $_REQUEST["id"];
            $sql = "SELECT
            ad.name, adn.adminId, adn.id, adn.title, adn.regDate, adn.content, adn.filePath, adn.fileName
            FROM tblAdmin ad JOIN tblDocument adn ON ad.id = adn.adminId
            WHERE adn.id = '{$id}'";

            return $this->getRow($sql);
        }

        function getReport(){
            $id = $_REQUEST["id"];
            $sql = "SELECT
            ad.name, adn.adminId, adn.id, adn.title, adn.regDate, adn.content, 
            adn.filePath1, adn.fileName1,
            adn.filePath2, adn.fileName2,
            adn.filePath3, adn.fileName3,
            adn.filePath4, adn.fileName4,
            adn.filePath5, adn.fileName5
            FROM tblAdmin ad JOIN tblReport adn ON ad.id = adn.adminId
            WHERE adn.id = '{$id}'";

            return $this->getRow($sql);
        }

        function getNotice(){
            $id = $_REQUEST["id"];
            $sql = "SELECT
            ad.name, adn.adminId, adn.id, adn.title, adn.regDate, adn.content, adn.filePath, adn.fileName
            FROM tblAdmin ad JOIN tblAdminNotification adn ON ad.id = adn.adminId
            WHERE adn.id = '{$id}'";

            return $this->getRow($sql);
        }

        function dele1teNotice(){
            $sql = "DELETE FROM tblAdminNotification WHERE `id`='{$_REQUEST["id"]}'";
            $this->update($sql);
            return $this->makeResultJson(1, "");
        }

        function deleteDoc(){
            $sql = "DELETE FROM tblDocument WHERE `id`='{$_REQUEST["id"]}'";
            $this->update($sql);
            return $this->makeResultJson(1, "");
        }

        function deleteReport(){
            $sql = "DELETE FROM tblReport WHERE `id`='{$_REQUEST["id"]}'";
            $this->update($sql);
            return $this->makeResultJson(1, "");
        }

        function upsertDoc(){
            $check = file_exists($_FILES['docFile']['tmp_name'][0]);

            $id = $_REQUEST["id"];
            $adminId = $this->admUser->id;
            $title = $_REQUEST["title"];
            $content = $_REQUEST["content"];
            if($id == "") $id = 0;

            $fileName = $_FILES["docFile"]["name"];
            $filePath = $_REQUEST["filePath"];

            if($check !== false){
                $fName = $this->makeFileName() . "." . pathinfo(basename($_FILES["docFile"]["name"]),PATHINFO_EXTENSION);
                $targetDir = $this->filePath . $fName;
                if(move_uploaded_file($_FILES["docFile"]["tmp_name"], $targetDir)) $filePath = $fName;
                else return $this->makeResultJson(-1, "fail");
            }

            $sql = "INSERT INTO tblDocument(`id`, `adminId`, `title`, `fileName`, `filePath`, `content`, `regDate`)
                    VALUES(
                      '{$id}', 
                      '{$adminId}', 
                      '{$title}', 
                      '{$fileName}',
                      '{$filePath}',
                      '{$content}',
                      NOW()
                    )
                    ON DUPLICATE KEY UPDATE 
                      `title` = '{$title}', 
                      `adminId`='{$adminId}', 
                      `content` = '{$content}',
                      `fileName` = '{$fileName}',
                      `filePath` = '{$filePath}'
                  ";

            $this->update($sql);
            return $this->makeResultJson(1, "");
        }

        function upsertReport(){
            $fileArray = array();
            $id = $_REQUEST["id"];
            $adminId = $this->admUser->id;
            $title = $_REQUEST["title"];
            $content = $_REQUEST["content"];
            if ($id == "") $id = 0;

            for($i = 0; $i < 5; $i++) {
                $check = file_exists($_FILES['docFile'.($i+1)]['tmp_name']);

                $fileName = $_FILES["docFile".($i+1)]["name"];
                $filePath = $_REQUEST["filePath".($i+1)];

                if ($check !== false) {
                    $fName = $this->makeFileName() . "." . pathinfo(basename($_FILES["docFile".($i+1)]["name"]), PATHINFO_EXTENSION);
                    $targetDir = $this->filePath . $fName;
                    if (move_uploaded_file($_FILES["docFile".($i+1)]["tmp_name"], $targetDir)) $filePath = $fName;
                    else return $this->makeResultJson(-1, "fail");
                }else{
                    if($filePath != ""){
                        $fileName = $_REQUEST["fileName".($i+1)];
                    }else {
                        $fileName = "";
                        $filePath = "";
                    }
                }

                $fileArray[$i]["fileName"] = $fileName;
                $fileArray[$i]["filePath"] = $filePath;

            }

            $sql = "INSERT INTO tblReport(`id`, `adminId`, `title`,
                    `fileName1`, `filePath1`,
                    `fileName2`, `filePath2`,
                    `fileName3`, `filePath3`,
                    `fileName4`, `filePath4`,
                    `fileName5`, `filePath5`, 
                    `content`, `regDate`)
                    VALUES(
                      '{$id}', 
                      '{$adminId}', 
                      '{$title}', 
                      '{$fileArray[0]["fileName"]}', '{$fileArray[0]["filePath"]}',
                      '{$fileArray[1]["fileName"]}', '{$fileArray[1]["filePath"]}',
                      '{$fileArray[2]["fileName"]}', '{$fileArray[2]["filePath"]}',
                      '{$fileArray[3]["fileName"]}', '{$fileArray[3]["filePath"]}',
                      '{$fileArray[4]["fileName"]}', '{$fileArray[4]["filePath"]}',
                      '{$content}',
                      NOW()
                    )
                    ON DUPLICATE KEY UPDATE 
                      `title` = '{$title}', 
                      `adminId`='{$adminId}', 
                      `content` = '{$content}',
                      `fileName1` = '{$fileArray[0]["fileName"]}',
                      `filePath1` = '{$fileArray[0]["filePath"]}',
                      `fileName2` = '{$fileArray[1]["fileName"]}',
                      `filePath2` = '{$fileArray[1]["filePath"]}',
                      `fileName3` = '{$fileArray[2]["fileName"]}',
                      `filePath3` = '{$fileArray[2]["filePath"]}',
                      `fileName4` = '{$fileArray[3]["fileName"]}',
                      `filePath4` = '{$fileArray[3]["filePath"]}',
                      `fileName5` = '{$fileArray[4]["fileName"]}',
                      `filePath5` = '{$fileArray[4]["filePath"]}'
                  ";
            $this->update($sql);
            return $this->makeResultJson(1, "");
        }

        function upsertNotice(){
            $check = file_exists($_FILES['imgFile']['tmp_name'][0]);

            $id = $_REQUEST["id"];
            $adminId = $this->admUser->id;
            $title = $_REQUEST["title"];
            $content = $_REQUEST["content"];
            if($id == "") $id = 0;

            $fileName = $_FILES["imgFile"]["name"];
            $filePath = $_REQUEST["filePath"];

            if($check !== false){
                $fName = $this->makeFileName() . "." . pathinfo(basename($_FILES["imgFile"]["name"]),PATHINFO_EXTENSION);
                $targetDir = $this->filePath . $fName;
                if(move_uploaded_file($_FILES["imgFile"]["tmp_name"], $targetDir)) $filePath = $fName;
                else return $this->makeResultJson(-1, "fail");
            }

            $sql = "INSERT INTO tblAdminNotification(`id`, `adminId`, `title`, `fileName`, `filePath`, `content`, `regDate`)
                    VALUES(
                      '{$id}', 
                      '{$adminId}', 
                      '{$title}',
                      '{$fileName}',
                      '{$filePath}', 
                      '{$content}', 
                      NOW()
                    )
                    ON DUPLICATE KEY UPDATE 
                      `title` = '{$title}', 
                      `adminId`='{$adminId}', 
                      `content` = '{$content}',
                      `fileName` = '{$fileName}',
                      `filePath` = '{$filePath}'
                  ";

            $this->update($sql);
            return $this->makeResultJson(1, "");
        }

        function getContinents(){
            $sql = "SELECT *, (SELECT COUNT(*) FROM tblNationGroup WHERE tblContinent.`id` = fContinent) AS ncnt FROM tblContinent ORDER BY `name` ASC";
            return $this->getArray($sql);
        }

        function getContinent($id){
            $sql = "SELECT * FROM tblContinent WHERE `id`='{$id}'";
            return $this->getRow($sql);
        }

        function getNations($id){
            $sql = "SELECT * FROM tblNationGroup WHERE `fContinent` = '{$id}' ORDER BY `desc` ASC";
            return $this->getArray($sql);
        }

        function getAllNation(){
            $sql = "SELECT * FROM tblNationGroup ORDER BY `desc` ASC";
            return $this->getArray($sql);
        }

        function getContinentCode($nation){
            $sql = "SELECT continentCode FROM tblContinent WHERE `id` = (SELECT fContinent FROM tblNationGroup WHERE `id` = '{$nation}' LIMIT 1)";
            return $this->getValue($sql, "continentCode");
        }

        function getNationsByCode($id, $loc){
            $sql = "
            SELECT *, (SELECT `name` FROM tblNationLang WHERE lang='{$loc}' AND nationId = tblNationGroup.id) AS locName
            FROM tblNationGroup 
            WHERE `fContinent` = (SELECT `id` FROM tblContinent WHERE continentCode = '{$id}' LIMIT 1)
            ORDER BY `desc` ASC;
            ";
            return $this->getArray($sql);
        }

        function deleteFaq(){
            $fid = $_REQUEST["id"];
            $sql = "DELETE FROM tblFaqLang WHERE `faqId`='{$fid}'";
            $this->update($sql);
            $sql = "DELETE FROM tblFaq WHERE `id`='{$fid}'";
            $this->update($sql);
            return $this->makeResultJson(1, "succ");
        }

        function getNation($id){
            $sql = "SELECT * FROM tblNationGroup WHERE `id`='{$id}'";
            return $this->getRow($sql);
        }

        function getSupportParents($id){
            $sql = "SELECT * FROM tblSupportParent WHERE `nationId` = '{$id}' ORDER BY regDate DESC";
            return $this->getArray($sql);
        }

        function getSupport($id, $loc){
            $sql = "
            SELECT * FROM tblSupportArticle 
            WHERE 
            parentId = '{$id}'
            AND
            locale = '{$loc}'
            ";
            return $this->getRow($sql);
        }

        function getLastSupportNumber($id){
            $sql = "SELECT id FROM tblSupportParent WHERE nationId='{$id}' ORDER BY regDate DESC LIMIT 1";
            return $this->getValue($sql, "id");
        }

        function getLastStories($id, $loc){
            $sql = "
            SELECT parentId, titleImg FROM tblSupportArticle 
            WHERE 
            parentId IN (SELECT id FROM tblSupportParent WHERE nationId='{$id}' ORDER BY regDate DESC)
            AND
            locale = '{$loc}'
            ORDER BY regDate DESC LIMIT 1, 5
            ";
            return $this->getArray($sql);
        }

        function getProperty($name){
            $sql = "SELECT `value` FROM tblProperty WHERE propertyName='{$name}';";
            return $this->getValue($sql, "value");
        }

        function getProperties($prefix, $loc){
            $sql = "SELECT * FROM tblProperty WHERE lang = '{$loc}' AND propertyName LIKE '{$prefix}%';";
            return $this->getArray($sql);
        }

        function getPropertyLoc($name, $loc){
            $sql = "SELECT `value` FROM tblProperty WHERE propertyName='{$name}' AND lang='{$loc}'";
            return $this->getValue($sql, "value");
        }

        function getPropertyLocAjax(){
            return $this->getPropertyLoc($_REQUEST["name"], $_REQUEST["lang"]);
        }

        function setPropertyAjax(){
            return $this->setProperty($_REQUEST["name"], $_REQUEST["value"]);
        }

        function setPropertyLocAjax(){
            return $this->setPropertyLoc($_REQUEST["name"], $_REQUEST["lang"], $_REQUEST["value"]);
        }

        function setPropertyLoc($name, $loc, $value){
            $sql = "
            INSERT INTO tblProperty(propertyName, `desc`, `lang`, `value`) VALUES('{$name}', '', '{$loc}', '{$value}')
            ON DUPLICATE KEY UPDATE `value` = '{$value}'
            ";
            $this->update($sql);
            return $this->makeResultJson(1, "succ");
        }

        function setPropertyOnlyValue($name, $loc, $value){
            $sql = "
            INSERT INTO tblProperty(propertyName, `lang`, `value`) VALUES('{$name}', '{$loc}', '{$value}')
            ON DUPLICATE KEY UPDATE `value` = '{$value}'
            ";
            $this->update($sql);
            return $this->makeResultJson(1, "succ");
        }

        function setPropertyLocDesc($name, $loc, $value, $desc){
            $sql = "
            INSERT INTO tblProperty(propertyName, `desc`, `lang`, `value`) VALUES('{$name}', '{$desc}', '{$loc}', '{$value}')
            ON DUPLICATE KEY UPDATE `value` = '{$value}', `desc` = '{$desc}'
            ";
            $this->update($sql);
            return $this->makeResultJson(1, "succ");
        }

        function setPropertyAllAjax(){
            $sql = "SELECT * FROM tblLang ORDER BY `order` ASC;";
            $arr = $this->getArray($sql);
            for($e = 0; $e < sizeof($arr); $e++){
                $this->setPropertyLocDesc($_REQUEST["name"], $arr[$e]["code"], $_REQUEST["value"], $_REQUEST["desc"]);
            }
            return $this->makeResultJson(1, "succ");
        }

        function setProperty($name, $value){
            $sql = "
            INSERT INTO tblProperty(propertyName, `desc`, `lang`, `value`) VALUES('{$name}', '', '#', '{$value}')
            ON DUPLICATE KEY UPDATE `value` = '{$value}'
            ";
            $this->update($sql);
            return $this->makeResultJson(1, "succ");
        }

        function setPropertyWithData(){
            $check = getimagesize($_FILES["imgFile"]["tmp_name"]);

            $imgPath = NULL;
            $imgPathIntro = NULL;

            if($check !== false){
                $fName = $this->makeFileName() . "." . pathinfo(basename($_FILES["imgFile"]["name"]),PATHINFO_EXTENSION);
                $targetDir = $this->filePath . $fName;
                if(move_uploaded_file($_FILES["imgFile"]["tmp_name"], $targetDir)) $imgPath = $fName;
                else return $this->makeResultJson(-1, "fail");
            }
            else $imgPath = $_REQUEST["imgPath"];

            $pName = $_REQUEST["propertyName"];
            $pLoc = $_REQUEST["loc"];
            $pValue = $imgPath;

            $this->setPropertyOnlyValue($pName, $pLoc, $pValue);

            return $this->makeResultJson(1, "succ");
        }

        function getNowSchedule($type){
            $sql = "SELECT COUNT(*) AS rn FROM tblSchedule WHERE `start` <= DATE(NOW()) AND `end` >= DATE(NOW()) AND `type`='{$type}'";
            return $this->getValue($sql, "rn");
        }

    }

}