<?php

$table = date("Ymd",strtotime("+1 DAY"));

$sql = "CREATE TABLE `tbl_trivia_promotion_".$table."` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `MSISDN` bigint(20) NOT NULL,
  `DND` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1";
$conn  = connect_db();
if($conn){
    mysqli_query($conn,$sql);
    mysqli_close($conn);
}
function connect_db(){
    $conn = mysqli_connect("localhost","promotion_table_create","PezBZH2TzmbWeC@z4","tigo_sms_broadcast");
    return $conn;
}