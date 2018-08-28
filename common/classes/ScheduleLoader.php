<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminBase.php" ;?>
<?
if(!class_exists("ScheduleLoader")){
    class ScheduleLoader extends  AdminBase {

        function __construct($req){
            parent::__construct($req);
        }

        function getSchedule(){
            $sql = "SELECT *, (SELECT `name` FROM tblAdmin WHERE tblAdmin.`id`=tblSchedule.`authorId`) AS adminName
                    FROM tblSchedule WHERE `id`='{$_REQUEST["id"]}'";
            return $this->getRow($sql);
        }

        function getMonthlySchedule(){
            $sql = "SELECT `id`, `title`, `start`, `end` 
                    FROM tblSchedule 
                    WHERE `type`='{$_REQUEST["type"]}' AND DATE('{$_REQUEST["start"]}') <= `start` AND DATE('{$_REQUEST["end"]}') >= `end`";

            $URL_PREFIX = "/admin/pages/staffService/scheduleDetail.php?id=";
            $arr = $this->getArray($sql);

            $retVal = array();
            for($e = 0; $e < sizeof($arr); $e++){
                $item = $arr[$e];
                $retVal[$e] = array(
                    "url" => $URL_PREFIX.$item["id"],
                    "title" => $item["title"],
                    "start" => $item["start"],
                    "end" => $item["end"],
                );
            }

            return json_encode($retVal);
        }

        function upsertSchedule(){
            $sid = $_REQUEST["sid"] == "" ? 0 : $_REQUEST["sid"];
            $sql = "
            INSERT INTO tblSchedule(`id`, `authorId`, `title`, `start`, `type`, `end`, `content`)
            VALUES(
            '{$sid}', 
            '{$_REQUEST["authorId"]}',
            '{$_REQUEST["title"]}',
            '{$_REQUEST["start"]}',
            '{$_REQUEST["jCls"]}',
            '{$_REQUEST["end"]}',
            '{$_REQUEST["content"]}')
            ON DUPLICATE KEY UPDATE 
            `authorId`='{$_REQUEST["authorId"]}',
            `title`='{$_REQUEST["title"]}',
            `start`='{$_REQUEST["start"]}',
            `type` = '{$_REQUEST["jCls"]}',
            `end`='{$_REQUEST["end"]}',
            `content`='{$_REQUEST["content"]}'
            ";
            $this->update($sql);

            return $this->makeResultJson(1, "succ");
        }

        function deleteSchedule(){
            $sql = "DELETE FROM tblSchedule WHERE `id`='{$_REQUEST["id"]}'";
            $this->update($sql);

            return $this->makeResultJson(1, "succ");
        }

    }

}