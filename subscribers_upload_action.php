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
        $query = "LOAD DATA LOCAL INFILE '".$file."' INTO TABLE `".$table."`  FIELDS TERMINATED BY ','  LINES TERMINATED BY '".'\n'. "' (MSISDN) SET ID = NULL";
        mysqli_query($con, $query);
}
    function connect_db(){
        $user = FILE_USER;
        $pass = FILE_PASSWORD;
        $db = DB;
        mysqli_connect(DB_HOST,$user,$pass,$db);

    }


}

header("Location: subscribers_upload.php?uploaded=1");
