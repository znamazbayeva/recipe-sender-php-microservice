<?php

require_once './php/vendor/autoload.php';

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

// CloudAMQP configuration
$host = 'moose-01.rmq.cloudamqp.com';
$port = 5672;
$user = 'fnnpqkez';
$password = 'Zwj9VVWoBgwGka3di1VEQAb31gS7ElrX';
$vhost = 'fnnpqkez';

// Initiated connection to CloudAMQP
$conn = new AMQPStreamConnection($host, $port, $user, $password, $vhost);
$channel = $conn->channel();

// Queue name, this name must be same with consumer.
$queueName = 'profile';
$channel->queue_declare($queueName, false, false, false, false);

// Connect to database 
$servername = "localhost";
$username = "zhuldyz";
$password = "CsMuso00";

// Create connection
$connSQL = new mysqli($servername, $username, $password);

// Check connection
if ($connSQL->connect_error) {
  die("Connection failed: " . $connSQL->connect_error);
} 
echo "Connected successfully";

$sql = "SELECT * FROM users";
$result = $connSQL->query($sql);

class Letter {
    // Properties
    // public $user;
    public $recipe;
    public $date;

    // Methods
    // function set_user($user) {
    //     $this->user = $user;
    // }
    function set_recipe($recipe) {
        $this->recipe = $recipe;
    }
    function set_date($date) {
        $this->date = $date;
    }
}

$random_recipe = http_get("www.themealdb.com/api/json/v1/1/random.php");

if ($result->num_rows > 0) {
// output data of each row
while($row = $result->fetch_assoc()) {

    $letter = new Letter();
    // $letter->set_user($row);
    $letter->set_recipe($random_recipe);
    $letter->set_date(date());
    $myJSON = json_encode($letter);

    // Initiate message to be send to consumer
    $msg = new AMQPMessage($myJSON);
    $channel->basic_publish($msg, '', $queueName);
    echo 'Message has been sent and place inside queue.';
}
} else {
    echo "0 results";
}
  $connSQL->close();

// Close channel and connection
$channel->close();
$conn->close();
