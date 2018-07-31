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

		//log list
		function searchLog(){
		    $page = $this->req["page"];
		    $limit = $this->rowPerPage;
		    $search = $this->req["searchText"];

            $request = array("page" => $page, "limit" => $limit, "search" => $search);
            $actionUrl = "{$this->serverRoot}/web/logs";
            $retVal = $this->getData($actionUrl, $request);
            $list = json_decode($retVal)->data;

            return $list;
        }

        //chatBot response
        function instantResponse(){
		    $msg = $this->req["msg"];

		    $request = array("msg" => $msg);
		    $actionUrl = "{$this->serverRoot}/web/instant";
		    $retVal = $this->getData($actionUrl, $request);

		    return json_decode($retVal)->data;
        }

        function deleteLog(){
            $no = $this->req["no"];

            $actionUrl = "{$this->serverRoot}/web/delete/".$no;
            $retVal = $this->getData($actionUrl, Array());

            return $retVal;
        }

        function getDashBoardData(){
            $actionUrl = "{$this->serverRoot}/web/dashboard";
            $retVal = $this->getData($actionUrl, Array());

            return $retVal;
        }
		
	}
}