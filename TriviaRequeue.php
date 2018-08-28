<?php
set_time_limit(0);
ini_set('memory_limit', '-1');
require_once __DIR__ . '/vendor/autoload.php';
require_once 'config.php';
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
     $channel->basic_recover($callback,1);
     
        
while (count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();




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
$table = "tigo_broadcast_logs_".date("Ymd");
$sql = "INSERT INTO `".$table."` (`MSISDN`,`SMS`,`response`)VALUES ('".$msisdn."','".$sms."','".$response."')";
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
