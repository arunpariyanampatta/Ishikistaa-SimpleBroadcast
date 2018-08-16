<?php
$table_name = "";
$promotionName = "";
$senderID = "";
$message = "";

$are_all_fields_set = 0;
$msg_published_and_workers_started = 0;

if(isset($_GET['tbl_name']) && isset($_GET['promotionName'])
    && isset($_GET['senderID']) && isset($_GET['message'])){
    $table_name = $_GET['tbl_name'];
    $promotionName = $_GET['promotionName'];
    $senderID = $_GET['senderID'];
    $message = $_GET['message'];
    $are_all_fields_set = 1;

    file_put_contents("content-config.php","<?php define('CONTENT','".$message."');");

    //TODO
    //publish msgs and start workers logic here
}
header("Location: home.php?published_and_started=1");