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
            $check = file_exists($_FILES['docFileDelivery']['tmp_name']);
            $targetDir = "";

            if($check !== false){
                $fName = $this->makeFileName() . "." . pathinfo(basename($_FILES["docFileDelivery"]["name"]),PATHINFO_EXTENSION);
                if(pathinfo(basename($_FILES["docFileDelivery"]["name"]),PATHINFO_EXTENSION) == "xls" || pathinfo(basename($_FILES["docFileDelivery"]["name"]),PATHINFO_EXTENSION) == "xlsx"){
                    $targetDir = $_SERVER["DOCUMENT_ROOT"] . "/uploadFiles/" . $fName;
                    if(!move_uploaded_file($_FILES["docFileDelivery"]["tmp_name"], $targetDir)) return $this->makeResultJson(-1, "Failed to read the file.");
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
                    $email = $objWorksheet->getCell('A' . $i)->getValue(); // A열
                    $name = $objWorksheet->getCell('B' . $i)->getValue(); // A열
                    $shippingDate = $objWorksheet->getCell('C' . $i)->getValue(); // B열
                    $info = $objWorksheet->getCell('D' . $i)->getValue(); // C열
                    $cnt = $objWorksheet->getCell('E' . $i)->getValue(); // D열
                    $addr = $objWorksheet->getCell('F' . $i)->getValue(); // D열
                    $content = $objWorksheet->getCell('G' . $i)->getValue();

                    $sql = "
                        SELECT id FROM tblCustomer WHERE `email` = '{$email}'
                    ";
                    $customerId = $this->getValue($sql, "id");

                    if($customerId != ""){
                        $sql = "
                            INSERT INTO tblCustomerDeliveryHistory(customerId, name, shippingDate, info, cnt, addr, content, regDate)
                            VALUES(
                              '{$customerId}',
                              '{$name}',
                              '{$shippingDate}',
                              '{$info}',
                              '{$cnt}',
                              '{$addr}',
                              '{$content}',
                              NOW()
                            )
                        ";
                        $this->update($sql);
                    }
                }

            }
            catch (exception $e) {
                return $this->makeResultJson(-1, "Failed to parse.", $lastRead);
            }

            return $this->makeResultJson(1, "File Parsed Successfully.", $lastRead);
        }

        function parsePaymentList(){
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
                    $email = $objWorksheet->getCell('D' . $i)->getValue();

                    $sql = "
                        SELECT * FROM tblCustomer WHERE email = '{$email}' LIMIT 1
                    ";
                    $customerInfo = $this->getRow($sql);
                    $customerId = $customerInfo["id"];

                    $customerType = $objWorksheet->getCell('A' . $i)->getValue();
                    $customerPhone = $objWorksheet->getCell('B' . $i)->getValue();
                    $customerName = $objWorksheet->getCell('C' . $i)->getValue();
                    $zipcode = $objWorksheet->getCell('E' . $i)->getValue();
                    $addr = $objWorksheet->getCell("F" . $i)->getValue();
                    $addrDetail = $objWorksheet->getCell("G" . $i)->getValue();
                    $cName = $objWorksheet->getCell("H" . $i)->getValue();
                    $cPhone = $objWorksheet->getCell("I" . $i)->getValue();
                    $rank = $objWorksheet->getCell("J" . $i)->getValue();

                    if($customerInfo == ""){
                        //TODO customer INSERT
                        $sql = "
                            INSERT INTO tblCustomer(`type`, name, phone, email, zipcode, addr, addrDetail, cName, cPhone, rank, langCode, regDate)
                            VALUES(
                              '{$customerType}',
                              '{$customerName}',
                              '{$customerPhone}',
                              '{$email}',
                              '{$zipcode}',
                              '{$addr}',
                              '{$addrDetail}',
                              '{$cName}',
                              '{$cPhone}',
                              '{$rank}',
                              'kr',
                              NOW()
                            ) 
                        ";
                        $this->update($sql);
                        $customerId = $this->mysql_insert_id();
                    }
                    $cardType = $objWorksheet->getCell("K" . $i)->getValue();
                    $bankCode = $objWorksheet->getCell("L" . $i)->getValue();
                    $owner = $objWorksheet->getCell("M" . $i)->getValue();
                    $info = $objWorksheet->getCell("N" . $i)->getValue();
                    $validThruYear = $objWorksheet->getCell("O" . $i)->getValue();
                    $validThruMonth = $objWorksheet->getCell("P" . $i)->getValue();
                    $buyType = $objWorksheet->getCell("Q" . $i)->getValue();
                    $monthlyDate = $objWorksheet->getCell("R" . $i)->getValue();
                    //TODO payMethod INSERT
                    if($cardType == "") $cardType = -1;
                    $sql = "
                        INSERT INTO tblPayMethod(customerId, cardTypeId, bankCode, ownerName, `type`, info, validThruYear, validThruMonth, regDate)
                        VALUES(
                          '{$customerId}',
                          '{$cardType}',
                          '{$bankCode}',
                          '{$owner}',
                          'CC',
                          '{$info}',
                          '{$validThruYear}',
                          '{$validThruMonth}',
                          NOW()
                        ) 
                    ";
                    $this->update($sql);
                    $payMethodId = $this->mysql_insert_id();

                    $paymentResult = $objWorksheet->getCell("AH" . $i)->getValue();
                    //TODO tblPayment INSERT
                    $sql = "
                        INSERT INTO tblPayment(payMethodId, buyType, `type`, monthlyDate, paymentResult, regDate)
                        VALUES(
                          '{$payMethodId}',
                          '{$buyType}',
                          'CC',
                          '{$monthlyDate}',
                          '{$paymentResult}',
                          NOW()    
                        )
                    ";
                    $this->update($sql);
                    $paymentId = $this->mysql_insert_id();

                    //TODO subscription/support INSERT
                    if($buyType == "SUB"){
                        $publicationId = $objWorksheet->getCell("S" . $i)->getValue();
                        $publicationCnt = $objWorksheet->getCell("T" . $i)->getValue();
                        $pYear = $objWorksheet->getCell("U" . $i)->getValue();
                        $pMonth = $objWorksheet->getCell("V" . $i)->getValue();
                        $totalPrice = $objWorksheet->getCell("W" . $i)->getValue();
                        $subType = $objWorksheet->getCell("X" . $i)->getValue();
                        $shipType = $objWorksheet->getCell("Y" . $i)->getValue();
                        $subStatus = $objWorksheet->getCell("Z" . $i)->getValue();

                        $sql = "
                            INSERT INTO tblSubscription(customerId, publicationId, cnt, pYear, pMonth, totalPrice, subType, shippingType, rName, rPhone, rZipCode, rAddr, rAddrDetail, paymentId, deliveryStatus, regDate)
                            VALUES(
                              '{$customerId}',
                              '{$publicationId}',
                              '{$publicationCnt}',
                              '{$pYear}',
                              '{$pMonth}',
                              '{$totalPrice}',
                              '{$subType}',
                              '{$shipType}',
                              '{$customerName}',
                              '{$customerPhone}',
                              '{$zipcode}',
                              '{$addr}',
                              '{$addrDetail}',
                              '{$paymentId}',
                              '{$subStatus}',
                              NOW()
                            ) 
                        ";
                        $this->update($sql);

                    }else if($buyType == "SUP"){
                        $parentId = $objWorksheet->getCell("AA" . $i)->getValue();
                        $cnt = $objWorksheet->getCell("AB" . $i)->getValue();
                        $type = $objWorksheet->getCell("AC" . $i)->getValue();
                        $supType = $objWorksheet->getCell("AD" . $i)->getValue();
                        $totalPrice = $objWorksheet->getCell("AE" . $i)->getValue();
                        $sYear = $objWorksheet->getCell("AF" . $i)->getValue();
                        $sMonth = $objWorksheet->getCell("AG" . $i)->getValue();

                        $sql = "
                            INSERT INTO tblSupport(customerId, parentId, cnt, `type`, supType, totalPrice, rName, rEmail, rPhone, paymentId, sYear, sMonth, regDate)
                            VALUES(
                              '{$customerId}',
                              '{$paymentId}',
                              '{$cnt}',
                              '{$type}',
                              '{$supType}',
                              '{$totalPrice}',
                              '{$customerName}',
                              '{$email}',
                              '{$customerPhone}',
                              '{$paymentId}',
                              '{$sYear}',
                              '{$sMonth}',
                              NOW()
                            )
                        ";
                        $this->update($sql);
                    }
                }

            }
            catch (exception $e) {
                return $this->makeResultJson(-1, "Failed to parse.", $lastRead);
            }

            return $this->makeResultJson(1, "File Parsed Successfully.", $lastRead);
        }

    }

}