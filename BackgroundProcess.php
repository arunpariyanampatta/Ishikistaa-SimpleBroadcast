<?php
if (isset($_SESSION['fullname'])) {
    $user = $_SESSION['fullname'];
}

require_once __DIR__ . '/vendor/autoload.php';
require_once 'config.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


$msgs_published = 0;
if(isset($_POST['ProcessType'])) {
    $process = $_POST['ProcessType'];

    if($process=="Publish") {
        if (isset($_POST['tbl_name']) && isset($_POST['promotionName']) && isset($_POST['senderID']) && isset($_POST['message'])) {
            $table_name = $_POST['tbl_name'];
            $promotionName = $_POST['promotionName'];
            $senderID = $_POST['senderID'];
            $message = $_POST['message'];
            $msgs_published = 1;
            file_put_contents("content-config.php", "<?php define('CONTENT','" . $message . "');");
            shell_exec("php TriviaPublisher.php &");
        }
        exit;
    }
if($process=="Consume") {
        
        
            shell_exec("");
           
       exit;     
    }
    elseif($process=="QueueCheck"){

        $connection = new AMQPStreamConnection('localhost', 5672, 'arun', 'aruntest123');
        $channel = $connection->channel();
        list($queue, $messageCount, $consumerCount) = $channel->queue_declare('tigo_trivia_broadcast', true);

        $queuearray = array("Messagecount"=>$messageCount,"consumercount"=>$consumerCount);

        echo json_encode($queuearray);
        return json_encode($queuearray);
    }
}
