<?php
set_time_limit(0);
ini_set('memory_limit', '-1');
require_once __DIR__ . '/vendor/autoload.php';
require_once 'config.php';
require_once 'content-config.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
$i = 0;
$id = 0;

while(true){
    $i=$i+1;
$connection = new AMQPStreamConnection('localhost', 5672, 'arun', 'aruntest123');
$channel = $connection->channel();	
$conn = connectDB();
$table = TABLE;
$sql = "SELECT SUB_ID,MSISDN  from ".$table." WHERE SUB_ID > ".$id."  AND DND_STATUS = '0' AND ACTIVITY_STATUS = 'ACTIVE'  ORDER BY SUB_ID ASC LIMIT 200";
$result = mysqli_query($conn,$sql);
$brodcast = array();
while($row = mysqli_fetch_array($result)){
$brodcast[] = $row;
}
if(empty($brodcast)){ 
exit;  
}
else{
$channel->queue_declare('tigo_trivia_broadcast', false, true, false, false);
$max_id = end($brodcast);
$id = $max_id['SUB_ID'];
for($j=0;$j<sizeof($brodcast);$j++){
$str['MSISDN'] = $brodcast[$j]['MSISDN'];
$msg = new AMQPMessage(json_encode($str));
$channel->basic_publish($msg, '', 'tigo_trivia_broadcast');
}
echo " [x] Sent. ". sizeof($brodcast)." Published to Queue ID IS ".$id."\n";
$channel->close();
$connection->close();
mysqli_close($conn);
sleep(1);
if($i>=10){
    $i = 0;
}
}
}
function connectDB(){
	$conn  =  mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB);
        	if($conn){
		return $conn;
	}
	else{
		return false;
	}
}

function split_array($array, $slices) {
  $perSlice = floor(count($array) / $slices);
  $sliceExtra = count($array) % $slices;

  $slicesArray = array();
  $offset = 0;

  for($i = 0; $i < $slices; $i++) {
    $extra = (($sliceExtra--) > 0) ? 1 : 0;
    $slicesArray[] = array_slice($array, $offset, $perSlice + $extra);
    $offset += $perSlice + $extra;
  }

  return $slicesArray;
}

