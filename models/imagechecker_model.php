<?php

class Imagechecker_model extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getImages($controller)
    {
        $width = $_POST['maxWidth'];
        $height = $_POST['maxHeight'];

        $resultDB = $this->accessImageDB();
        $this->checkSize($controller, $resultDB, $width, $height);

        $controller->view->render("imagechecker/index");

    }

    function savePicture($uploadFile, $productSKU, $fileName)
    {
        if (!empty($uploadFile)) {

            $data = $this->recordLocator($fileName);

            foreach ($data as $product) {
                foreach ($product as $colName => $value) {
                    if ($value == $fileName) {
                        $prepareDB = $this->prepareDB->prepare("UPDATE htl_sku2extraimages SET " . $colName . " = '". $uploadFile ."' WHERE id = " . $productSKU);
                        $prepareDB->execute();
                    }
                }
            }
        }
    }

    public function recordDelete()
    {
        $fileName = $_POST['fileName'];
        $data = $this->recordLocator($fileName);

        foreach ($data as $product) {
            $productSKU = $_POST['sku'];

            foreach ($product as $colName => $value) {
                if ($value == $fileName) {
                    $prepareDB = $this->prepareDB->prepare("UPDATE htl_sku2extraimages SET " . $colName . "= NOT NULL WHERE id = " . $productSKU);
                    $prepareDB->execute();
                }
            }
        }

        if (file_exists("images/" . $fileName)) {
            unlink("images/" . $fileName);
        }
    }

    private function recordLocator($fileName)
    {
        $prepareDB = $this->prepareDB->prepare("SELECT * FROM htl_sku2extraimages WHERE kit_sku_1 LIKE '%$fileName%'
OR
kit_sku_2 LIKE '%$fileName%'
OR
kit_sku_3 LIKE '%$fileName%'
OR
kit_sku_4 LIKE '%$fileName%'
OR
kit_sku_5 LIKE '%$fileName%'
OR
kit_sku_6 LIKE '%$fileName%'
OR
kit_sku_7 LIKE '%$fileName%'
OR
kit_sku_8 LIKE '%$fileName%'
OR
kit_sku_9 LIKE '%$fileName%'
OR
kit_sku_10 LIKE '%$fileName%'
OR
battery_sku LIKE '%$fileName%'
OR
charger_sku LIKE '%$fileName%'
OR
container_sku LIKE '%$fileName%'");

        $prepareDB->execute();

        $data = $prepareDB->fetchAll();

        return $data;
    }

    private function accessImageDB()
    {
        //If the table is likely to change in terms of columns then I would look at turning the table into an object or looking at a different approach for now this works but can be updated in a later revision.
        $prepareDB = $this->prepareDB->prepare("SELECT id, kit_sku_1 FROM htl_sku2extraimages WHERE kit_sku_1 LIKE '%.%'
UNION ALL
SELECT id, kit_sku_2 FROM htl_sku2extraimages WHERE kit_sku_2 LIKE '%.%'
UNION ALL
SELECT id, kit_sku_3 FROM htl_sku2extraimages WHERE kit_sku_3 LIKE '%.%'
UNION ALL
SELECT id, kit_sku_4 FROM htl_sku2extraimages WHERE kit_sku_4 LIKE '%.%'
UNION ALL
SELECT id, kit_sku_5 FROM htl_sku2extraimages WHERE kit_sku_5 LIKE '%.%'
UNION ALL
SELECT id, kit_sku_6 FROM htl_sku2extraimages WHERE kit_sku_6 LIKE '%.%'
UNION ALL
SELECT id, kit_sku_7 FROM htl_sku2extraimages WHERE kit_sku_7 LIKE '%.%'
UNION ALL
SELECT id, kit_sku_8 FROM htl_sku2extraimages WHERE kit_sku_8 LIKE '%.%'
UNION ALL
SELECT id, kit_sku_9 FROM htl_sku2extraimages WHERE kit_sku_9 LIKE '%.%'
UNION ALL
SELECT id, kit_sku_10 FROM htl_sku2extraimages WHERE kit_sku_10 LIKE '%.%'
UNION ALL
SELECT id, battery_sku FROM htl_sku2extraimages WHERE battery_sku LIKE '%.%'
UNION ALL
SELECT id, charger_sku FROM htl_sku2extraimages WHERE charger_sku LIKE '%.%'
UNION ALL
SELECT id, container_sku FROM htl_sku2extraimages WHERE container_sku LIKE '%.%' ORDER BY id ASC");

        $prepareDB->execute();

        $data = $prepareDB->fetchAll();

        return ($data);
    }

    private function checkSize($controller, $array, $inputWidth, $inputHeight)
    {
        $errorResults = array();
        $results = array();

        foreach ($array as $image) {

            $fileName = pathinfo($image["kit_sku_1"], PATHINFO_FILENAME);
            $fileExt = pathinfo($image["kit_sku_1"], PATHINFO_EXTENSION);

            //records starting with a numerical value convert the file extension to capitals causing an error because files cannot be found without correct extension.
            $needle = $fileName . "." . strtolower($fileExt);

            //Records such as "TEMG12LI_1.jpg " have spaces at the end this is to trim that space away
            if (strpos($needle, " ")) {
                $needle = trim($needle, " ");
            }

            list($width, $height) = getimagesize("images/" . $needle);

            $imageType = mime_content_type("images/" . $needle);

            //check that the image is not broken. Could turn this into a delete function to update the database/remove the file from the folder if there is an encoding issue.
            if (strpos($imageType, "text") !== false or empty($imageType)) {
//                $errorResults['id'] = $image['id'];
//                $errorResults['fileName'] = $needle;
                $errorResults[] = array("sku" => $image['id'], "fileName" => $needle);
//                array_push($errorResults, $image['id'], $needle);
            } else if ($width <= $inputWidth && $height <= $inputHeight) {
                $results[] = array("sku" => $image['id'], "fileName" => $needle, "width" => $width, "height" => $height, "type" => mime_content_type("images/" . $needle));

            }

        }

        if (count($errorResults) > 0) {
            $controller->view->corruptFailure = $errorResults;
            $controller->view->imageResultsFailure = "Images were found with corrupted file types please results below";
        }
        if (count($results) > 0) {
            $controller->view->imageResults = $results;
        } else {
            $controller->view->imageResultsSuccess = "No images found";
        }

        return 0;
    }


}