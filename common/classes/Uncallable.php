<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminBase.php" ;?>
<?
if(!class_exists("Uncallable")){
    class Uncallable extends  AdminBase {

        function __construct($req){
            parent::__construct($req);
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
            FROM tblAdmin ad LEFT JOIN tblAdminNotification adn ON ad.id = adn.adminId
            ORDER BY adn.regDate DESC
            LIMIT 7
            ";
            return $this->getArray($sql);
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

        function setProperty($name, $value){
            $sql = "
            INSERT INTO tblProperty(propertyName, `desc`, `lang`, `value`) VALUES('{$name}', '', '#', '{$value}')
            ON DUPLICATE KEY UPDATE `value` = '{$value}'
            ";
            $this->update($sql);
            return $this->makeResultJson(1, "succ");
        }

    }

}