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

        function getNation($id){
            $sql = "SELECT * FROM tblNationGroup WHERE `id`='{$id}'";
            return $this->getRow($sql);
        }

        function getSupportParents($id){
            $sql = "SELECT * FROM tblSupportParent WHERE `nationId` = '{$id}' ORDER BY regDate DESC";
            return $this->getArray($sql);
        }

    }

}