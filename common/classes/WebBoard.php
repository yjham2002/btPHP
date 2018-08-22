<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebBase.php" ;?>
<?
if(!class_exists("WebBoard")){
	class WebBoard extends  WebBase {
		
		function __construct($req)
		{
			parent::__construct($req);
		}

		function getBoardCategory(){
            $code = $_REQUEST["code"];
            $sql = "
                SELECT BT.*, 
                (SELECT IFNULL(COUNT(*), 0) FROM tblBoard WHERE boardTypeId = BT.id) AS articleCnt,
                (SELECT IFNULL(SUM(viewCnt), 0) FROM tblBoard WHERE boardTypeId = BT.id) AS viewCnt
                FROM tblBoardType BT WHERE BT.`lang` = '{$code}'             
            ";

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

        function faqList(){
		    $langCode = $_COOKIE["btLocale"];
		    $sql = "
		        SELECT * FROM tblFaqLang WHERE `langCode` = '{$langCode}' AND `exposure` = 1
		    ";
		    return $this->getArray($sql);
        }

        function saveArticle(){
            $check = getimagesize($_FILES["imgFile"]["tmp_name"]);

            $boardTypeId =$_REQUEST["boardTypeId"];
            $customerId = $this->webUser->id;
            if($customerId == "") return $this->makeResultJson(-1, "fail");
            $title = $_REQUEST["title"];
            $content = $_REQUEST["content"];

            $imgPath = NULL;
            if($check !== false){
                $fName = $this->makeFileName() . "." . pathinfo(basename($_FILES["imgFile"]["name"]),PATHINFO_EXTENSION);
                $targetDir = $this->filePath . $fName;
                if(move_uploaded_file($_FILES["imgFile"]["tmp_name"], $targetDir)) $imgPath = $fName;
                else return $this->makeResultJson(-1, "fail");
            }
            else
                $imgPath = $_REQUEST["imgPath"];

            $sql = "
                INSERT INTO tblBoard(`boardTypeId`, `customerId`, `title`, `content`, `imgPath`, `regDate`)
                VALUES(
                  '{$boardTypeId}',
                  '{$customerId}',
                  '{$title}',
                  '{$content}',
                  '{$imgPath}',
                  NOW()
                )
            ";
            $this->update($sql);
            return $this->makeResultJson(1, "succ");
        }

        function increaseArticleView(){
		    $id = $_REQUEST["id"];
		    $sql = "UPDATE tblBoard SET `viewCnt` = (`viewCnt` + 1) WHERE `id` = '{$id}'";
		    $this->update($sql);
		    return $this->makeResultJson(1, "succ");
        }
	}
}