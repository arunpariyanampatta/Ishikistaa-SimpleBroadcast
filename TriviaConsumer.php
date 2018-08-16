<?php
set_time_limit(0);
ini_set('memory_limit', '-1');
require_once __DIR__ . '/vendor/autoload.php';
require_once 'config.php';
require_once 'content-config.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
$connection = new AMQPStreamConnection('localhost', 5672, 'arun', 'aruntest123');
$channel = $connection->channel();
$channel2 = $connection->channel();
$channel3 = $connection->channel();
$channel4 = $connection->channel();
$channel5 = $connection->channel();
$channel6 = $connection->channel();
$channel7 = $connection->channel();
$channel8 = $connection->channel();
$channel9 = $connection->channel();
$channel10 = $connection->channel();

 
echo " [*] Waiting for messages. To exit press CTRL+C \n";
$callback = function ($msg) {
$message =  json_decode($msg->body,TRUE);
$mobile 	=  $message['MSISDN'];
$deliveryState = brodcastSMS($mobile);
if($deliveryState){
$msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
}

};

 
     $channel->queue_declare('tigo_trivia_broadcast', false, true, false, false);//Second Element Should be true to make it durable so that we don't lose our queue
     $channel->basic_qos(null,QOS_LIMIT,null);
     $channel->basic_consume('tigo_trivia_broadcast', '', false, false, false, false, $callback); // auto ack is false
       
     
     $channel2->queue_declare('tigo_trivia_broadcast', false, true, false, false);//Second Element Should be true to make it durable so that we don't lose our queue
     $channel2->basic_qos(null,QOS_LIMIT,null);
     $channel2->basic_consume('tigo_trivia_broadcast', '', false, false, false, false, $callback); // auto ack is false
     
     $channel3->queue_declare('tigo_trivia_broadcast', false, true, false, false);//Second Element Should be true to make it durable so that we don't lose our queue
     $channel3->basic_qos(null,QOS_LIMIT,null);
     $channel3->basic_consume('tigo_trivia_broadcast', '', false, false, false, false, $callback); // auto ack is false
     
     $channel4->queue_declare('tigo_trivia_broadcast', false, true, false, false);//Second Element Should be true to make it durable so that we don't lose our queue
     $channel4->basic_qos(null,QOS_LIMIT,null);
     $channel4->basic_consume('tigo_trivia_broadcast', '', false, false, false, false, $callback); // auto ack is false

     $channel5->queue_declare('tigo_trivia_broadcast', false, true, false, false);//Second Element Should be true to make it durable so that we don't lose our queue
     $channel5->basic_qos(null,QOS_LIMIT,null);
     $channel5->basic_consume('tigo_trivia_broadcast', '', false, false, false, false, $callback); // auto ack is false
     
     $channel6->queue_declare('tigo_trivia_broadcast', false, true, false, false);//Second Element Should be true to make it durable so that we don't lose our queue
     $channel6->basic_qos(null,QOS_LIMIT,null);
     $channel6->basic_consume('tigo_trivia_broadcast', '', false, false, false, false, $callback); // auto ack is false
     
     
     $channel7->queue_declare('tigo_trivia_broadcast', false, true, false, false);//Second Element Should be true to make it durable so that we don't lose our queue
     $channel7->basic_qos(null,QOS_LIMIT,null);
     $channel7->basic_consume('tigo_trivia_broadcast', '', false, false, false, false, $callback); // auto ack is false
     
     
     
     $channel8->queue_declare('tigo_trivia_broadcast', false, true, false, false);//Second Element Should be true to make it durable so that we don't lose our queue
     $channel8->basic_qos(null,QOS_LIMIT,null);
     $channel8->basic_consume('tigo_trivia_broadcast', '', false, false, false, false, $callback); // auto ack is false
     
     $channel9->queue_declare('tigo_trivia_broadcast', false, true, false, false);//Second Element Should be true to make it durable so that we don't lose our queue
     $channel9->basic_qos(null,QOS_LIMIT,null);
     $channel9->basic_consume('tigo_trivia_broadcast', '', false, false, false, false, $callback); // auto ack is false
     
     
     $channel10->queue_declare('tigo_trivia_broadcast', false, true, false, false);//Second Element Should be true to make it durable so that we don't lose our queue
     $channel10->basic_qos(null,QOS_LIMIT,null);
     $channel10->basic_consume('tigo_trivia_broadcast', '', false, false, false, false, $callback); // auto ack is false
     
     
        
while (count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();


while (count($channel2->callbacks)) {
    $channel2->wait();
}

$channel2->close();

while (count($channel3->callbacks)) {
    $channel3->wait();
}

$channel3->close();

while (count($channel4->callbacks)) {
    $channel4->wait();
}

$channel4->close();

while (count($channel5->callbacks)) {
    $channel5->wait();
}

$channel5->close();

while (count($channel6->callbacks)) {
    $channel6->wait();
}

$channel6->close();

while (count($channel7->callbacks)) {
    $channel7->wait();
}

$channel7->close();

while (count($channel8->callbacks)) {
    $channel8->wait();
}

$channel8->close();

while (count($channel9->callbacks)) {
    $channel9->wait();
}

$channel9->close();

while (count($channel10->callbacks)) {
    $channel10->wait();
}

$channel10->close();

$connection->close();


function  brodcastSMS($msisdn){
$sms = CONTENT;
$dt = date("ymdhis");
                    $dt = date('ymdhis');
					$requestID = $dt.$msisdn;
					$milliseconds = round(microtime(true) * 1000);
					$str =  "751#".$milliseconds;
$enckey = "cMOQuv12yzbwi2Ve";
$encrypt = encrypt($str,$enckey);
$headersArray = array('Content-type: application/json','Cache-Control: no-cache','Pragma: no-cache',
        'apikey : 5baf6a6c7c764de9859b9beb4f8d7856','authentication : '.$encrypt.'','requestId : '.$requestID.'');
$headers_sent = json_encode($headersArray); 
$jsonArray = array("msisdn"=>$msisdn,"countryId"=>"255","productId"=>"5265","pricepointId"=>"1723","text"=>"".$sms."","mcc"=>"640","mnc"=>"02","context"=>"STATELESS","requestId"=>"".$requestID."","largeAccount"=>"15670","priority"=>"NORMAL");
$json = json_encode($jsonArray);

$url =  "https://tigo.timwe.com/tz/ma/api/external/v1/sms/mt/645";



                $ch = curl_init ();
                curl_setopt($ch,CURLOPT_URL,$url);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
                curl_setopt($ch,CURLOPT_TIMEOUT,100);
                curl_setopt($ch,CURLOPT_POST,true);
                curl_setopt($ch,CURLOPT_POSTFIELDS,$json);
                curl_setopt($ch,CURLOPT_HTTPHEADER,$headersArray);
                $dataresp = curl_exec($ch);
                if($dataresp){
                    insert_record($sms,$msisdn,$dataresp);
                date_default_timezone_set('Africa/Dar_Es_Salaam');
                    return TRUE;
                    
                }
                else{
                    
                    return FALSE;
                }
                



}


    function encrypt($str, $key){
     $block = mcrypt_get_block_size('rijndael_128', 'ecb');
     $pad = $block - (strlen($str) % $block);
     $str .= str_repeat(chr($pad), $pad);
     return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_ECB));
}


function insert_record($sms,$msisdn,$response){
$conn = connect_db();
$sql = "INSERT INTO tigo_brodcast_logs (`MSISDN`,`SMS`,`response`)VALUES ('".$msisdn."','".$sms."','".$response."')";
mysqli_query($conn,$sql);

mysqli_close($conn);
}



function connect_db(){
$conn = mysqli_connect(DB_HOST,DB_CONSUMER_USER,DB_PASSWORD,DB);
if($conn){


	return $conn;
}

else{

	return false;
}

}
