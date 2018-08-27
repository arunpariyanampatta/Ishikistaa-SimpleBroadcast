<?php

$conn = connect_db();

$date = date("Ymd");
$sql = "SHOW TABLES LIKE '%".$date."%' ";


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

//    $conn = mysqli_connect("localhost", "root", "", "sms_portal");

    if($conn){

        return $conn;
    }
    else{

        return false;
    }
}