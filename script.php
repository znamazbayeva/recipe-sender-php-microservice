<?php

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;
$vhost = 'fnnpqkez';
$host = 'moose-01.rmq.cloudamqp.com';
$port = 5672;
$user = 'fnnpqkez';
$password = 'Zwj9VVWoBgwGka3di1VEQAb31gS7ElrX';

// Initiated connection to CloudAMQP
$conn = new AMQPStreamConnection($host, 5672, $user, $password, $vhost);
$channel = $conn->channel();

$response =file_get_contents("https://www.themealdb.com/api/json/v1/1/random.php");
$letter = json_decode($response);

// Queue name, this name must be same with consumer.
$queueName = 'mail';
$channel->queue_declare($queueName, false, false, false, false);

// Initiate message to be send to consumer
$msg = new AMQPMessage( $letter);
$channel->basic_publish($msg, '', $queueName);

echo 'Message has been sent and place inside queue.';

// Close channel and connection
$channel->close();
$conn->close();