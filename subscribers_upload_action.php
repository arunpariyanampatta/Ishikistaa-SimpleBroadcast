<?php

require 'vendor/autoload.php';
require_once 'config.php';
require_once 'query.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

error_reporting(-1);
$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
if(isset($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {
    $moduler = SUBS_UPLOAD_SIZE;
    $mdl_rslt = -1;
    $sql = "";
    $arr_file = explode('.', $_FILES['file']['name']);
    $extension = end($arr_file);
    if('csv' == $extension) {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
    } else {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    }
    $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
    $worksheet = $spreadsheet->getActiveSheet();
    $n = 0;
    $i = 1;
    foreach ($worksheet->getRowIterator() as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(FALSE);
        foreach ($cellIterator as $cell) {
            $msisdn = $cell->getValue();
            if(!strcasecmp($msisdn, "MSISDN")){
                continue;
            }
            $mdl_rslt = $i % $moduler;
             if($mdl_rslt == 1 || $moduler == 1){
                 $sql = "INSERT INTO test_20180823(MSISDN) VALUES('".$msisdn."')";
                 if($moduler == 1){
                     insert_subscribers($conn, $sql);
                     $sql = "";
                 }
             }else if($mdl_rslt > 1){
                 $sql .= ",('".$msisdn."')";
             }else if($mdl_rslt == 0){
                 $sql .= ",('".$msisdn."')";
                 insert_subscribers($conn, $sql);
                 $sql = "";
             }
            ++$n;
            ++$i;
        }
    }
    if(strlen($sql) > 0 ){
        insert_subscribers($conn, $sql);
    }
}

header("Location: subscribers_upload.php?uploaded=1&msisdn_nm=".$n);
