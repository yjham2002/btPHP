<?include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/comm/Common.php";?>
<?

if (! class_exists("AdminBase"))
{

	class AdminBase extends Common
	{

		function __construct($req)
		{
			parent::__construct($req);
		}

		function wrapParam()
		{
			$this->req['page'] = ($this->req['page'] == "") ? 1 : $this->req['page'];
		}

		function getAddQuery()
		{
			$addQuery = "";
			$addQuery .= $this->getSearchQuery();
			
			return $addQuery;
		}

		/**
		 * *************************************************************************
		 * 제 목 : 이미지 파일 사이즈 구하기
		 * 함수명 : fileUpload
		 * 작성일 : 2013-07-22
		 * 작성자 : dev.Na
		 * 설 명 :
		 * 수 정 :
		 * '**************************************************************************
		 */
		function getImageSize($imgUrl)
		{
			$imgUrl = $this->fileSavePath . $imgUrl;
			
			$imgExtension = Array(
				'GIF',
				'JPG',
				'PNG',
				'PSD',
				'BMP'
			);
			
			if (in_array(strtoupper($this->getFileExtension($imgUrl)), $imgExtension))
			{
				$sizeInfo = getimagesize($imgUrl);
				$file_width = $sizeInfo[0];
				$file_height = $sizeInfo[1];
			}
			else
			{
				$file_width = "0";
				$file_height = "0";
			}
			
			$retArr = Array(
				"file_name" => str_replace($this->fileSavePath, "", $imgUrl),
				"file_width" => $file_width,
				"file_height" => $file_height
			);
			
			return $retArr;
		}
		
		// 파일명중 확장자를 분리해준다.
		function getFileExtension($imgUrl)
		{
			$Tmp = explode(".", $imgUrl);
			
			return $Tmp[count($Tmp) - 1];
		}

		function imagePreUpload()
		{
			$Extension = array(
				"txt",
				"html",
				"asp",
				"php"
			);
			$Upload = new Upload($_FILES["file"], $this->fileSavePath, $Extension, 1);
			$imgData = $Upload->processing();
			
			$imagePath = "";
			
			if (strcmp($imgData[0]['re_name'], ""))
			{
				$imagePath = $Upload->GetDate() . "/" . $imgData[0]['re_name'];
				$image = new SimpleImage();
				$assoc = array(
					$this->fileSavePath_720,
					$this->fileSavePath_640,
					$this->fileSavePath_480,
					$this->fileSavePath_320,
					$this->fileSavePath_100
				);
				
				$image->check($assoc);
				
				$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_720, 720, $imgData[0]['re_name']);
				$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_640, 640, $imgData[0]['re_name']);
				$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_480, 480, $imgData[0]['re_name']);
				$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_320, 320, $imgData[0]['re_name']);
				$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_100, 100, $imgData[0]['re_name']);
			}
			
			$imagePath = ($imagePath != "") ? "/upload_img/" . $imagePath : $imagePath;
			
			return $imagePath;
		}

		/**
		 * 그룹 검색
		 * 
		 * @param unknown $name        	
		 */
		function getListOfGroupForEntity($name)
		{
			$sql = "
				SELECT *
				FROM tbl_user_group 
				WHERE status = 'Y' AND name LIKE '%{$name}%'
				ORDER BY name ASC
			";
			
			$result = $this->getArray($sql);
			
			return $result;
		}
		
		/**
		 * 상점 검색
		 * @param unknown $name
		 */
		function getListOfShopForEntity($name)
		{
			$sql = "
				SELECT *
				FROM tbl_shop
				WHERE status = 'Y' AND name LIKE '%{$name}%'
				ORDER BY name ASC
			";
				
			$result = $this->getArray($sql);
				
			return $result;
		}
		
		/**
		 * 상점 카테고리 코드 검색
		 */
		function getShopCategoryCodeList()
		{
			$sql = "
				SELECT *
				FROM tbl_category
		 		WHERE `status` = 'Y'
				ORDER BY `no` ASC
			";
			$result = $this->getArray($sql);
			
			return $result;
		}
		
		/**
		 * 그룹 정보 조회
		 * @param unknown $groupNo
		 * @return NULL
		 */
		function getGroupData($groupNo)
		{
			
			$sql = "
				SELECT *
				FROM tbl_user_group
				WHERE `no` = '{$groupNo}'
				LIMIT 1
			";
			$result = $this->getRow($sql);
				
			return $result;
		}
		
		
		
		
	} // class 종료
}
?>