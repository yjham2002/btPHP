<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebBase.php" ;?>
<?php
if(! class_exists("WebMain") )	{

    class WebMain extends Common {
        function __construct($req) {
            parent::__construct($req);
        }

        //mindMap data
        function getMindMapData(){
            $companyNo = $this->webUser[companyNo];

            $request = $this->lnFn_Common_CrPost(array("level" => 0 ));
            $actionUrl = "{$this->serverRoot}/map/company/".$companyNo;
            $retVal = $this->postData($actionUrl, $request);

            return $retVal;
        }

        //TODO addMotor excel parse
        function uploadFile(){

            $imgResult = $this->inFn_Common_fileSave($_FILES);
            $filePathMotorInfo = $imgResult["filePathMotorInfo"]["saveURL"] != "" ? $imgResult["filePathMotorInfo"]["saveURL"] : $this->req["filePathMotorInfo"];


            $request = $this->lnFn_Common_CrPost(array("url" => $filePathMotorInfo ));
            $actionUrl = "{$this->serverRoot}/data/parse";
            $retVal = $this->postData($actionUrl, $request);

            return $retVal;
        }

        //spectrum View data
        function getSpectrumData(){
            $motorNo = $this->req["motorNo"];

            return getSpectrumDataWithParam($motorNo);
        }

        function getSingleSpectrumData(){
            $uuid = $this->req[uuid];

            $paramsArray = array("type" => "vHA");
            $request = $this->lnFn_Common_CrPost($paramsArray);
            $actionUrl = "{$this->serverRoot}/data/typedSpectrum/".$uuid;
            $retVal = $this->postData($actionUrl, $request);

            return $retVal;
        }

        function getSpectrumDataWithParam($motorNo, $id = 0){
            if($motorNo == ""){
                throw new Exception();
            }

            $paramsArray = array("id" => $id);
            $request = $this->lnFn_Common_CrPost($paramsArray);
            $actionUrl = "{$this->serverRoot}/data/spectrum/".$motorNo;
            $retVal = $this->postData($actionUrl, $request);

            return $retVal;
        }

        function getCompanyInfo(){
            if($this->req["cKey"] == "")
                $companyNo = $this->webUser[companyNo];
            else
                $companyNo = $this->req["cKey"];

            $actionUrl = "{$this->serverRoot}/data/company/detail/".$companyNo;
            $retVal = $this->getData($actionUrl);

            return $retVal;
        }

        //App factory List Api
        function getFactoryList(){
            if($this->req["companyNo"] == "")
                $companyNo = $this->webUser[companyNo];
            else
                $companyNo = $this->req["companyNo"];

            $request = $this->lnFn_Common_CrPost(array("page" => 0 ));
            $actionUrl = "{$this->serverRoot}/data/plant/".$companyNo;
            $retVal = $this->postData($actionUrl, $request);

            return $retVal;
        }

        function getFactoryInfo(){
            $factoryNo = $this->req["pKey"];


            $actionUrl = "{$this->serverRoot}/data/plant/detail/".$factoryNo;
            $retVal = $this->getData($actionUrl);

            return $retVal;
        }

        //App group List Api
        function getGroupList(){
            $factoryNo = $this->req["factoryNo"];

            $request = $this->lnFn_Common_CrPost(array("page" => 0 ));
            $actionUrl = "{$this->serverRoot}/data/group/".$factoryNo;
            $retVal = $this->postData($actionUrl, $request);

            return $retVal;
        }

        function getGroupInfo(){
            $groupNo = $this->req["gKey"];

            $actionUrl = "{$this->serverRoot}/data/group/detail/".$groupNo;
            $retVal = $this->getData($actionUrl);

            return $retVal;
        }

        //App motor List Api
        function getMotorList(){
            $groupNo = $this->req["groupNo"];

            $request = $this->lnFn_Common_CrPost(array("page" => 0 ));
            $actionUrl = "{$this->serverRoot}/data/motor/".$groupNo;
            $retVal = $this->postData($actionUrl, $request);

            return $retVal;
        }

        //motorInfo Api
        function getMotorInfo(){
            $uuid = $this->req["mKey"];

            $actionUrl = "{$this->serverRoot}/data/motor/detail/".$uuid;
            $retVal = $this->getData($actionUrl);

            return $retVal;
        }

        //Web motor save Api
        function saveMotors(){
            $jsonText = $this->req["motorInfo"];

            $request = $this->lnFn_Common_CrPost(array("json" => json_encode($jsonText)));
            $actionUrl = "{$this->serverRoot}/data/saveMotor";
            $retVal = $this->postData($actionUrl, $request);

            return $retVal;
        }
    }
}
?>