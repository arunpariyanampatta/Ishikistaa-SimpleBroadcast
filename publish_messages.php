<?php
$table_name = "";
$promotionName = "";
$senderID = "";
$message = "";

$msgs_published = 0;

if(isset($_GET['tbl_name']) && isset($_GET['promotionName']) && isset($_GET['senderID']) && isset($_GET['message'])){
    $table_name = $_GET['tbl_name'];
    $promotionName = $_GET['promotionName'];
    $senderID = $_GET['senderID'];
    $message = $_GET['message'];
    $msgs_published = 1;

    file_put_contents("content-config.php","<?php define('CONTENT','".$message."');");

    //TODO
    //publish messages logic here
}
header("Location: home.php?msgs_published=".$msgs_published);