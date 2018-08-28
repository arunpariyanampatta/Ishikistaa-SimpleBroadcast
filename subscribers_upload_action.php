<?php

require 'vendor/autoload.php';
require_once 'config.php';
require_once 'query.php';
error_reporting(-1);
if(isset($_FILES['file']['name'])) {
    $path = "uploads/";
    $path = $path . basename( $_FILES['file']['name']);
    if(move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
        $file = $path;
        $con = connect_db();
        $table = "tbl_trivia_promotion_".date("Ymd");
        $truncate = "TRUNCATE ".$table;
        mysqli_query($conn,$truncate);
        $query = "LOAD DATA LOCAL INFILE '".$file."' INTO TABLE `".$table."`  FIELDS TERMINATED BY ','  LINES TERMINATED BY '".'\n'. "' (MSISDN) SET ID = NULL";
        $result = mysqli_query($con, $query);
        $n = $result->affected_rows;
        mysqli_close($con);
        unlink($path);
        header("Location: subscribers_upload.php?uploaded=1&msisdn_nm=".$n);
}
   


}


