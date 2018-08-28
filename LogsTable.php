<?php

$table = date("Ymd",strtotime("+1 DAY"));

$sql = " CREATE TABLE `tigo_broadcast_logs_".$table."` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `MSISDN` bigint(20) NOT NULL,
  `SMS` varchar(1000) NOT NULL,
  `RESPONSE` varchar(1000) DEFAULT NULL,
  `DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=999520 DEFAULT CHARSET=latin1";
$conn  = connect_db();
if($conn){
    mysqli_query($conn,$sql);
    mysqli_close($conn);
}
function connect_db(){
    $conn = mysqli_connect("localhost","promotion_table_create","PezBZH2TzmbWeC@z4","tigo_sms_broadcast");
    return $conn;
}
