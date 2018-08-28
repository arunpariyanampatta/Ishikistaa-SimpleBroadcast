<?php

$con = connect_db();
$file  = 'TEST3.csv';
        $query = "LOAD DATA LOCAL INFILE '".$file."' INTO TABLE tbl_trivia_promotion_20180827 FIELDS TERMINATED BY ','  LINES TERMINATED BY '".'\n'. "' (MSISDN) SET ID = NULL";
        echo $query;
         mysqli_query($con, $query);
            
function connect_db(){
     

    $conn =  mysqli_connect("localhost","file_import","MnLnSmmhCcuH4Ngy@","tigo_sms_broadcast");
     return $conn;
	 
     
 }
