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

                for ($i = 1 ; $i <= $maxRow ; $i++) {
                    $a = $objWorksheet->getCell('A' . $i)->getValue(); // A열
                    $b = $objWorksheet->getCell('B' . $i)->getValue(); // B열
                    $c = $objWorksheet->getCell('C' . $i)->getValue(); // C열
                    $d = $objWorksheet->getCell('D' . $i)->getValue(); // D열

                    echo $a."/".$b."/".$c."<br/>";
                }

            }
            catch (exception $e) {
                return $this->makeResultJson(-1, "Failed to parse.", $lastRead);
            }

            return $this->makeResultJson(1, "File Parsed Successfully.", $lastRead);
        }

    }

}