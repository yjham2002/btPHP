<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 7. 19.
 * Time: PM 4:12
 */
?>


<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/ApiBase.php" ;?>
<?
if(!class_exists("ApiList")){
    class ApiList extends  ApiBase {

        function __construct($req)
        {
            parent::__construct($req);
        }

        function getRecommendList(){
            $appId = $_REQUEST["appId"];

            $sql = "
                SELECT * 
                FROM tblRecommend
                WHERE appId = {$appId} AND exposure = 1
                ORDER BY `order` ASC 
            ";

            $res = $this->getArray($sql);
            return $this->makeResultJson(1, "succ", $res);
        }

        function checkUpdate(){
            $appId = $_REQUEST["appId"];

            $sql = "
                SELECT *
                FROM tblApps
                WHERE id = {$appId}
                LIMIT 1
            ";

            $res = $this->getRow($sql);
            return $this->makeResultJson(1, "succ", $res);
        }

        function getStageInfo(){
            $appId = $_REQUEST["appId"];

            $sql = "
                SELECT * FROM tblStage
                WHERE appId = {$appId}
                ORDER BY `order` ASC
            ";

            $stageList = $this->getArray($sql);

            for($i=0; $i<sizeof($stageList); $i++){
                $stageId = $stageList[$i]["id"];

                $sql = "
                    SELECT * FROM tblQuestion
                    WHERE stageId = {$stageId} 
                    ORDER BY `order` ASC
                ";

                $questionList = $this->getArray($sql);

                for($j=0; $j<sizeof($questionList); $j++){
                    $questionId = $questionList[$j]["id"];

                    $sql = "
                        SELECT * FROM tblAnswer
                        WHERE questionId = {$questionId}
                    ";

                    $answerList = $this->getArray($sql);
                    $questionList[$j]["answers"] = $answerList;
                }

                $stageList[$i]["questions"] = $questionList;
            }

            return $this->makeResultJson(1, "succ", $stageList);
        }

    }
}