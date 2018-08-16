<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once 'config.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


  $connection = new AMQPStreamConnection('localhost', 5672, 'arun', 'aruntest123');
        $channel = $connection->channel();
        list($queue, $messageCount, $consumerCount) = $channel->queue_declare('tigo_trivia_broadcast', true);
        
        $queuearray = array("Messagecount"=>$messageCount,"consumercount"=>$consumerCount);

        echo json_encode($queuearray);
        return;

