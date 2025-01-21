<?php
//include __DIR__ . '/../../connect.php';

function uploadImage($fileInput, $itemID, $processType)
{
    //Image Upload
    $htmlFileUpload = $_FILES[$fileInput]['name'];
    $htmlFileUploadTMP = $_FILES[$fileInput]['tmp_name'];

    $htmlFileName = '-' . $htmlFileUpload;
    $htmlNewName = date("YMdHisu");

    $htmlNewFileName = $htmlNewName . $htmlFileName;

    $htmlFolder = "../shared/assets/img/system/items/";

    if ($processType == "addItem") {
        move_uploaded_file($htmlFileUploadTMP, $htmlFolder . $htmlNewFileName);
        $insertAttachmentQuery = "INSERT INTO attachments(`itemID`, `fileName`) VALUES ('$itemID', '$htmlNewFileName')";
        executeQuery($insertAttachmentQuery);
    } else if ($processType == "editItem") {
        move_uploaded_file($htmlFileUploadTMP, $htmlFolder . $htmlNewFileName);
        if ($htmlFileUpload !== "") {
            $updateAttachmentQuery = "UPDATE `attachments` SET `fileName`='$htmlNewFileName' WHERE itemID = '$itemID'";
            executeQuery($updateAttachmentQuery);
        }
    }
}
