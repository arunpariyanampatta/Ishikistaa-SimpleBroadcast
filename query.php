<?php

$conn = connect_db();
$date = date("Ymd");
$sql = "show tables WHERE  Tables_in_tigo_sms_broadcast like '%".$date."%' and Tables_in_tigo_sms_broadcast not like '%logs%'";
$tableResult = mysqli_query($conn,$sql);
$tables  = array();
    while ($row = mysqli_fetch_array($tableResult)){
    $tables[] = $row;
    }

    function insert_subscribers($conn, $sql){
        mysqli_query($conn, $sql, MYSQLI_STORE_RESULT);
    }


function connect_db()
{
    $conn = mysqli_connect("localhost", "dashboard_user", "Ku2ZbNHdcALZfz2P@", "tigo_sms_broadcast");
    if($conn){

        return $conn;
    }
    else{

        return false;
    }
}