<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminBase.php"; ?>
<? require_once $_SERVER["DOCUMENT_ROOT"] . "/common/PHPExcel/Classes/PHPExcel.php"; ?>
<? require_once $_SERVER["DOCUMENT_ROOT"] . "/common/PHPExcel/Classes/PHPExcel/IOFactory.php"; ?>
<?
if(!class_exists("ExcelParser")){
    class ExcelParser extends  AdminBase {

        function __construct($req){
            parent::__construct($req);
        }

        function parseCustomerList(){
            $check = file_exists($_FILES['docFile']['tmp_name']);
            $targetDir = "";

            if($check !== false){
                $fName = $this->makeFileName() . "." . pathinfo(basename($_FILES["docFile"]["name"]),PATHINFO_EXTENSION);
                if(pathinfo(basename($_FILES["docFile"]["name"]),PATHINFO_EXTENSION) == "xls" || pathinfo(basename($_FILES["docFile"]["name"]),PATHINFO_EXTENSION) == "xlsx"){
                    $targetDir = $_SERVER["DOCUMENT_ROOT"] . "/uploadFiles/" . $fName;
                    if(!move_uploaded_file($_FILES["docFile"]["tmp_name"], $targetDir)) return $this->makeResultJson(-1, "Failed to read the file.");
                }else{
                    return $this->makeResultJson(-1, "Unexpected Extension of the file.");
                }
            }

            $objPHPExcel = new PHPExcel();

            $filename = $targetDir;
            $lastRead = 0;

            try {
                $objReader = PHPExcel_IOFactory::createReaderForFile($filename);
                $objReader->setReadDataOnly(true);
                $objExcel = $objReader->load($filename);

                $objExcel->setActiveSheetIndex(0); // Select First Sheet

                $objWorksheet = $objExcel->getActiveSheet();
                $rowIterator = $objWorksheet->getRowIterator();

                foreach ($rowIterator as $row) { // For All the rows
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);
                }

                $maxRow = $objWorksheet->getHighestRow();

                $data = array();

                for ($i = 3 ; $i <= $maxRow ; $i++) {
                    $name = $objWorksheet->getCell('D' . $i)->getValue();
                    $phone = $objWorksheet->getCell('E' . $i)->getValue();
                    $email = $objWorksheet->getCell('F' . $i)->getValue();
                    $zipcode = $objWorksheet->getCell('G' . $i)->getValue();
                    $addr = $objWorksheet->getCell('H' . $i)->getValue() . " " . $objWorksheet->getCell('I' . $i)->getValue();
                    $addrDetail = $objWorksheet->getCell('J' . $i)->getValue();
                    $history = $objWorksheet->getCell('W' . $i)->getValue();

                    $sql = "
                        SELECT * FROM tblCustomer WHERE email = '{$email}'
                    ";
                    $mem = $this->getRow($sql);
                    if($mem == ""){
                        $sql = "
                            INSERT INTO tblCustomer(`type`, name, phone, email, zipcode, addr, addrDetail, regDate)
                            VALUES(
                              '1',
                              '{$name}',
                              '{$phone}',
                              '{$email}',
                              '{$zipcode}',
                              '{$addr}',
                              '{$addrDetail}',
                              NOW()
                            )
                        ";
                        $this->update($sql);
                        $customerId = $this->mysql_insert_id();

                        $history = explode("\n", $history);
                        $tmp = Array();

                        for($t=0; $t<sizeof($history); $t++){
                            if($history[$t] != "") array_push($tmp, $history[$t]);
                        }


                        for($t=0; $t<sizeof($tmp); $t++){
                            $target = $tmp[$t];
                            $time = trim(substr($target, 0, strpos($target,"(")));

                            // 2018/4/25 PM 5:04:27
                            $tempArr1 = explode(" ", $time);
                            $dateArr = explode("/", $tempArr1[0]);
                            if(sizeof($dateArr) < 3) $dateArr = explode("-", $tempArr1[0]);
                            $timeArr = explode(":", $tempArr1[2]);

                            $postfixHour = $tempArr1[1] == "오후" ? 12 : 0;

                            $year = $dateArr[0];
                            $month = str_pad($dateArr[1], 2, "0", STR_PAD_LEFT);
                            $day = str_pad($dateArr[2], 2, "0", STR_PAD_LEFT);
                            $hour = str_pad((intval($timeArr[0]) + $postfixHour) % 24, 2, "0", STR_PAD_LEFT);
                            $min = str_pad($timeArr[1], 2, "0", STR_PAD_LEFT);
                            $sec = str_pad($timeArr[2], 2, "0", STR_PAD_LEFT);

                            $name = substr($target, strpos($target,"(") + 1, strpos($target,")") - strpos($target, "(") - 1);
                            $content = $target;
//                            $content = trim(substr($target, strpos($target,") - ") + 4));
                            $content = mysql_escape_string($content);

//
//                            echo $year."-".$month."-".$day." ".$hour.":".$min.":".$sec;
//                            echo "time:".$time ."\n";
//                            echo "name:".$name."\n";
//                            echo "content:".$content."\n";
//                            echo "-------------------------------\n";

                            if($name == "" || $content == "" || $time == ""){
                                continue;
                            }

                            $time = $year."-".$month."-".$day." ".$hour.":".$min.":".$sec;

                            $sql = "
                                INSERT INTO tblCustomerHistory(customerId, modifier, type, content, regDate)
                                VALUES(
                                  '{$customerId}',
                                  '{$name}',
                                  'etc',
                                  '{$content}',
                                  '{$time}'
                                )
                            ";

//                            echo $sql;
                            $this->update($sql);
                        }

                    }
                }

            }
            catch (exception $e) {
                return $this->makeResultJson(-1, "Failed to parse.", $lastRead);
            }

            return $this->makeResultJson(1, "File Parsed Successfully.", $lastRead);
        }

        function parseDeliveryHistory(){
            $id = $_REQUEST["id"];
            $check = file_exists($_FILES['docFile']['tmp_name']);
            $targetDir = "";

            if($check !== false){
                $fName = $this->makeFileName() . "." . pathinfo(basename($_FILES["docFile"]["name"]),PATHINFO_EXTENSION);
                if(pathinfo(basename($_FILES["docFile"]["name"]),PATHINFO_EXTENSION) == "xls" || pathinfo(basename($_FILES["docFile"]["name"]),PATHINFO_EXTENSION) == "xlsx"){
                    $targetDir = $_SERVER["DOCUMENT_ROOT"] . "/uploadFiles/" . $fName;
                    if(!move_uploaded_file($_FILES["docFile"]["tmp_name"], $targetDir)) return $this->makeResultJson(-1, "Failed to read the file.");
                }else{
                    return $this->makeResultJson(-1, "Unexpected Extension of the file.");
                }
            }

            $objPHPExcel = new PHPExcel();

            $filename = $targetDir;

            $lastRead = 0;

            try {
                $objReader = PHPExcel_IOFactory::createReaderForFile($filename);
                $objReader->setReadDataOnly(true);
                $objExcel = $objReader->load($filename);

                $objExcel->setActiveSheetIndex(0); // Select First Sheet

                $objWorksheet = $objExcel->getActiveSheet();
                $rowIterator = $objWorksheet->getRowIterator();

                foreach ($rowIterator as $row) { // For All the rows
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);
                }

                $maxRow = $objWorksheet->getHighestRow();

                $data = array();

                for ($i = 2 ; $i <= $maxRow ; $i++) {
                    $name = $objWorksheet->getCell('A' . $i)->getValue(); // A열
                    $shippingDate = $objWorksheet->getCell('B' . $i)->getValue(); // B열
                    $info = $objWorksheet->getCell('C' . $i)->getValue(); // C열
                    $cnt = $objWorksheet->getCell('D' . $i)->getValue(); // D열
                    $addr = $objWorksheet->getCell('E' . $i)->getValue(); // D열

//                    echo $name . "//" . $shippingDate . "//" .$info ."//" . $cnt ."//" . $addr;
//                    if(gettype($cnt) != "integer") continue;

                    $sql = "
                        INSERT INTO tblCustomerDeliveryHistory(customerId, name, shippingDate, info, cnt, addr, regDate)
                        VALUES(
                          '{$id}',
                          '{$name}',
                          '{$shippingDate}',
                          '{$info}',
                          '{$cnt}',
                          '{$addr}',
                          NOW()
                        )
                    ";
                    $this->update($sql);
                }

            }
            catch (exception $e) {
                return $this->makeResultJson(-1, "Failed to parse.", $lastRead);
            }

            return $this->makeResultJson(1, "File Parsed Successfully.", $lastRead);
        }

    }

}