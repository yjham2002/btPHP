<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminBase.php";?>
<?
if(!class_exists("Statistic")){
    class Statistic extends  AdminBase {

        function __construct($req){
            parent::__construct($req);
        }

        // TODO 쿼리 검증 혹은 기준 정보 수정
        function getGeneral(){
            $startYear = $_REQUEST["startYear"] == "" ? date("Y") : $_REQUEST["startYear"];
            $startMonth = $_REQUEST["startMonth"] == "" ? date("m") : $_REQUEST["startMonth"];
            $endYear = $_REQUEST["endYear"] == "" ? date("Y") : $_REQUEST["endYear"];
            $endMonth = $_REQUEST["endMonth"] == "" ? date("m") : $_REQUEST["endMonth"];

            $rangeArr = $this->getRangeAsArray($startYear, $startMonth, $endYear, $endMonth);

        }

        // TODO 쿼리 검증 혹은 기준 정보 수정
        function getNations(){
            $startYear = $_REQUEST["startYear"] == "" ? date("Y") : $_REQUEST["startYear"];
            $startMonth = $_REQUEST["startMonth"] == "" ? date("m") : $_REQUEST["startMonth"];
            $endYear = $_REQUEST["endYear"] == "" ? date("Y") : $_REQUEST["endYear"];
            $endMonth = $_REQUEST["endMonth"] == "" ? date("m") : $_REQUEST["endMonth"];

            $sql = "SELECT 
                    C.`name`, 
                    C.`id` AS cid, 
                    N.`desc`, 
                    N.`id` AS nid,
                    CASE WHEN S.`type` = 'RSUP' THEN DATE_FORMAT(NOW(),'%Y-%m')
                    ELSE DATE_FORMAT(S.`regDate`,'%Y-%m')
                    END AS legend,
                    SUM(S.totalPrice) AS cnt
                    FROM 
                    tblSupport S
                    JOIN tblSupportParent P 
                    JOIN tblContinent C 
                    JOIN tblNationGroup N 
                    ON C.`id`=N.`fContinent` AND P.`nationId` = N.`id` AND S.`parentId` = P.`id`
                    WHERE 
                    
                    (
                    S.`type` = 'TSUP' 
                    AND YEAR(S.`regDate`) = YEAR(NOW()) 
                    AND MONTH(S.`regDate`) = MONTH(NOW())
                    AND S.`regDate` BETWEEN DATE('$startYear-$startMonth-01') AND LAST_DAY(DATE('$endYear-$endMonth-01'))
                    )
                    OR
                    (
                    S.`type` = 'RSUP'
                    )
                    GROUP BY C.`id`, N.`id`, DATE_FORMAT(S.`regDate`,'%Y-%m')
                    ORDER BY C.`name`, N.`desc`";

            $list = $this->getArray($sql);
            $range = $this->getRangeAsArray($startYear, $startMonth, $endYear, $endMonth);
            $recur = $this->getRecurringSupport();

            $arr = array();

            for($e = 0; $e < sizeof($range); $e++){
                for($w = 0; $w < sizeof($list); $w++){
                    if(strtotime($recur[$list[$w]["desc"]]["start"]) <= strtotime($range[$e])){
                        $arr[$list[$w]["desc"]][$range[$e]] = $recur[$list[$w]["desc"]]["price"];
                    }else{
                        $arr[$list[$w]["desc"]][$range[$e]] = 0;
                    }
                }
            }

            for($e = 0; $e < sizeof($list); $e++){
                $arr[$list[$e]["desc"]][$list[$e]["legend"]] = $arr[$list[$e]["desc"]][$list[$e]["legend"]] + $list[$e]["cnt"];
            }

            return $arr;

        }

        // TODO 쿼리 검증 혹은 기준 정보 수정
        function getPrintFee(){
            $startYear = $_REQUEST["startYear"] == "" ? date("Y") : $_REQUEST["startYear"];
            $startMonth = $_REQUEST["startMonth"] == "" ? date("m") : $_REQUEST["startMonth"];
            $endYear = $_REQUEST["endYear"] == "" ? date("Y") : $_REQUEST["endYear"];
            $endMonth = $_REQUEST["endMonth"] == "" ? date("m") : $_REQUEST["endMonth"];

            $sql = "SELECT formJson, setDate, DATE_FORMAT(setDate,'%Y-%m') AS legend
                    FROM tblOrderform 
                    WHERE 
                    setDate BETWEEN 
                    DATE('$startYear-$startMonth-01') AND LAST_DAY(DATE('$endYear-$endMonth-01'))";

            $list = $this->getArray($sql);
            $range = $this->getRangeAsArray($startYear, $startMonth, $endYear, $endMonth);

            $arr = array();

            for($e = 0; $e < sizeof($list); $e++){
                $F_VALUE = json_decode(preg_replace('/[\x00-\x1F\x7F]/', '', nl2br($list[$e]["formJson"])), true);
                $productArray = $F_VALUE["products"];
                for($w = 0; $w < sizeof($productArray); $w++){
                    $toUpt = intval($arr[$productArray[$w]["name"]][$list[$e]["legend"]]) + (intval($productArray[$w]["unit"]) * intval($productArray[$w]["quantity"]));
                    $arr[$productArray[$w]["name"]][$list[$e]["legend"]] = $toUpt;
                }
            }

            return $arr;
        }

        // TODO 쿼리 검증 혹은 기준 정보 수정
        function getPrints(){
            $startYear = $_REQUEST["startYear"] == "" ? date("Y") : $_REQUEST["startYear"];
            $startMonth = $_REQUEST["startMonth"] == "" ? date("m") : $_REQUEST["startMonth"];
            $endYear = $_REQUEST["endYear"] == "" ? date("Y") : $_REQUEST["endYear"];
            $endMonth = $_REQUEST["endMonth"] == "" ? date("m") : $_REQUEST["endMonth"];

            $sql = "SELECT formJson, setDate, DATE_FORMAT(setDate,'%Y-%m') AS legend
                    FROM tblOrderform 
                    WHERE 
                    setDate BETWEEN 
                    DATE('$startYear-$startMonth-01') AND LAST_DAY(DATE('$endYear-$endMonth-01'))";

            $list = $this->getArray($sql);
            $range = $this->getRangeAsArray($startYear, $startMonth, $endYear, $endMonth);

            $arr = array();

            for($e = 0; $e < sizeof($list); $e++){
                $F_VALUE = json_decode(preg_replace('/[\x00-\x1F\x7F]/', '', nl2br($list[$e]["formJson"])), true);
                $productArray = $F_VALUE["products"];
                for($w = 0; $w < sizeof($productArray); $w++){
                    $toUpt = intval($arr[$productArray[$w]["name"]][$list[$e]["legend"]]) + (intval($productArray[$w]["quantity"]));
                    $arr[$productArray[$w]["name"]][$list[$e]["legend"]] = $toUpt;
                }
            }

            return $arr;
        }

        // TODO 쿼리 검증 혹은 기준 정보 수정
        function getResend(){
            $startYear = $_REQUEST["startYear"] == "" ? date("Y") : $_REQUEST["startYear"];
            $startMonth = $_REQUEST["startMonth"] == "" ? date("m") : $_REQUEST["startMonth"];
            $endYear = $_REQUEST["endYear"] == "" ? date("Y") : $_REQUEST["endYear"];
            $endMonth = $_REQUEST["endMonth"] == "" ? date("m") : $_REQUEST["endMonth"];

            $rangeArr = $this->getRangeAsArray($startYear, $startMonth, $endYear, $endMonth);

        }

        // TODO 쿼리 검증 혹은 기준 정보 수정
        function getShip(){
            $startYear = $_REQUEST["startYear"] == "" ? date("Y") : $_REQUEST["startYear"];
            $startMonth = $_REQUEST["startMonth"] == "" ? date("m") : $_REQUEST["startMonth"];
            $endYear = $_REQUEST["endYear"] == "" ? date("Y") : $_REQUEST["endYear"];
            $endMonth = $_REQUEST["endMonth"] == "" ? date("m") : $_REQUEST["endMonth"];

            $rangeArr = $this->getRangeAsArray($startYear, $startMonth, $endYear, $endMonth);

        }

        // TODO 쿼리 검증 혹은 기준 정보 수정
        function getSubscribeForGraph(){
            $startYear = $_REQUEST["startYear"] == "" ? date("Y") : $_REQUEST["startYear"];
            $startMonth = $_REQUEST["startMonth"] == "" ? date("m") : $_REQUEST["startMonth"];
            $endYear = $_REQUEST["endYear"] == "" ? date("Y") : $_REQUEST["endYear"];
            $endMonth = $_REQUEST["endMonth"] == "" ? date("m") : $_REQUEST["endMonth"];

            $sql = "SELECT 
                    DATE_FORMAT(`regDate`,'%Y-%m') AS legend, 
                    `publicationId`, 
                    `subType`, 
                    COUNT(*) AS cnt 
                    FROM tblSubscription 
                    WHERE 
                    `regDate` BETWEEN DATE('$startYear-$startMonth-01') AND LAST_DAY(DATE('$endYear-$endMonth-01'))
                    GROUP BY `subType`, DATE_FORMAT(`regDate`,'%Y-%m')";
            $list = $this->getArray($sql);

            $arr = array();
            for($e = 0; $e < sizeof($list); $e++){
                $arr[$list[$e]["subType"]][$list[$e]["legend"]] = $list[$e]["cnt"];
            }

            return $arr;
        }

        // TODO 쿼리 검증 혹은 기준 정보 수정
        function getSubscribeForTable(){
            $startYear = $_REQUEST["startYear"] == "" ? date("Y") : $_REQUEST["startYear"];
            $startMonth = $_REQUEST["startMonth"] == "" ? date("m") : $_REQUEST["startMonth"];
            $endYear = $_REQUEST["endYear"] == "" ? date("Y") : $_REQUEST["endYear"];
            $endMonth = $_REQUEST["endMonth"] == "" ? date("m") : $_REQUEST["endMonth"];

            $sql = "SELECT 
                    DATE_FORMAT(`regDate`,'%Y-%m') AS legend, 
                    `publicationId`, 
                    `subType`, 
                    COUNT(*) AS cnt 
                    FROM tblSubscription 
                    WHERE 
                    `regDate` BETWEEN DATE('$startYear-$startMonth-01') AND LAST_DAY(DATE('$endYear-$endMonth-01'))
                    GROUP BY `publicationId`, `subType`, DATE_FORMAT(`regDate`,'%Y-%m')";
            $list = $this->getArray($sql);
            $pubs = $this->getPublications();

            $arr = array();

            for($e = 0; $e < sizeof($list); $e++){
                $arr[$pubs[$list[$e]["publicationId"]]][$list[$e]["legend"]][$list[$e]["subType"]] = $list[$e]["cnt"];
            }

            return $arr;
        }

        /****************************************************************
         * 이하 함수들은 위 통계자료 산출을 위해 부가적으로 필요한 함수
         ****************************************************************/

        /**
         * 년월 범위를 받아 이를 문자열 배열로 반환
         * ex : 2014-02 ~ 2014-05
         * ex return : ["2014-02", "2014-03", "2014-04", "2014-05"]
         * @param $startYear
         * @param $startMonth
         * @param $endYear
         * @param $endMonth
         * @return array
         */
        function getRangeAsArray($startYear, $startMonth, $endYear, $endMonth){
            $arr = array();
            $cursor = 0;
            for($y = $startYear; $y <= $endYear; $y++){
                $fromLoopMonth = $y == $startYear ? $startMonth : 01;
                $toLoopMonth = $y == $endYear ? $endMonth : 12;
                for($m = intval($fromLoopMonth); $m <= $toLoopMonth; $m++){
                    $displayMonth = $m < 10 ? "0".$m : $m;
                    $arr[$cursor++] = $y."-".$displayMonth;
                }
            }
            return $arr;
        }

        function getRangeAsArrayFromRequest(){
            $startYear = $_REQUEST["startYear"] == "" ? date("Y") : $_REQUEST["startYear"];
            $startMonth = $_REQUEST["startMonth"] == "" ? date("m") : $_REQUEST["startMonth"];
            $endYear = $_REQUEST["endYear"] == "" ? date("Y") : $_REQUEST["endYear"];
            $endMonth = $_REQUEST["endMonth"] == "" ? date("m") : $_REQUEST["endMonth"];

            return $this->getRangeAsArray($startYear, $startMonth, $endYear, $endMonth);
        }

        /**
         * 간행물 번호에 간행물 이름이 삽입된 리스트 반환
         * @return array
         */
        function getPublications(){
            $sql = "SELECT * FROM tblPublication;";
            $list = $this->getArray($sql);
            $arr = array();
            for($i = 0; $i < sizeof($list); $i++){
                $arr[$list[$i]["id"]] = $list[$i]["desc"];
            }
            return $arr;
        }

        /**
         * 정기결제 금액을 국가명에 금액이 삽입된 리스트로 반환
         * @return array
         */
        function getRecurringSupport(){
            $sql = "SELECT C.`name`, C.`id` AS cid, N.`desc`, N.`id` AS nid, 
                    DATE_FORMAT(S.`regDate`,'%Y-%m') AS legend, 
                    SUM(S.totalPrice) AS cnt FROM tblSupport S 
                    JOIN tblSupportParent P JOIN tblContinent C 
                    JOIN tblNationGroup N ON C.`id`=N.`fContinent` 
                    AND P.`nationId` = N.`id` AND S.`parentId` = P.`id` 
                    WHERE 
                    S.`type` = 'RSUP'  
                    GROUP BY C.`id`, N.`id`, 
                    DATE_FORMAT(S.`regDate`,'%Y-%m') ORDER BY C.`name`, N.`desc`
                  ";
            $list = $this->getArray($sql);
            $arr = array();
            for($i = 0; $i < sizeof($list); $i++){
                $arr[$list[$i]["desc"]]["price"] = $list[$i]["cnt"] == "" ? 0 : $list[$i]["cnt"];
                $arr[$list[$i]["desc"]]["start"] = $list[$i]["legend"];
            }

            return $arr;
        }

    }

}