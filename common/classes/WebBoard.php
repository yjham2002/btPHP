<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebBase.php" ;?>
<?
/*
 * Web process
 * add by cho
 * */
if(!class_exists("WebBoard")){
	class WebBoard extends  WebBase {
		
		function __construct($req) 
		{
			parent::__construct($req);
		}

		function getBoardCategory(){
            $code = $_REQUEST["code"];
            $sql = "SELECT * FROM tblBoardType WHERE `lang` = '{$code}'";
            return $this->makeResultJson(1, "succ", $this->getArray($sql));
        }

        function getCategoryInfo(){
		    $id = $_REQUEST["categoryId"];
		    $sql = "SELECT * FROM tblBoardType WHERE `id` = '{$id}' LIMIT 1";
		    return $this->getRow($sql);
        }

        function getArticleList(){
		    $categoryId = $_REQUEST["categoryId"];
		    $sql = "
              SELECT *, (SELECT `name` FROM tblCustomer C WHERE C.id = customerId) AS userName 
              FROM tblBoard 
              WHERE `boardTypeId` = '{$categoryId}' 
              ORDER BY regDate DESC
            ";
		    return $this->getArray($sql);
        }

        function getArticleInfo(){
		    $id = $_REQUEST["articleId"];
		    $sql = "
		        SELECT *, (SELECT `name` FROM tblCustomer C WHERE C.id = customerId) AS userName
		        FROM tblBoard
		        WHERE `id` = '{$id}'
		        LIMIT 1
		    ";
		    return $this->getRow($sql);
        }
	}
}