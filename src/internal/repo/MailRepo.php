<?php

namespace Zhuldyz\RecipeSenderPhpMicroservice\internal\repo;

use PDO;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Zhuldyz\RecipeSenderPhpMicroservice\internal\entity\Mail;

class MailRepo
{
    private function connectDB(): PDO
    {
        $connection = new PDO("mysql:host=localhost;dbname=mail_db", "root", "zhanarys");
        return $connection;
    }

    public function getAll()
    {
        $pdo = $this->connectDB();
        $query = "SELECT * FROM mail";
        $data = $pdo->query($query)->fetchAll();

        $result = [];

        foreach ($data as $mailData) {
            $result[] = new Mail($mailData);
        }

        return $result;
    }

    public function create(array $mailData): Mail
    {
        $pdo = $this->connectDB();

        $mailData['id'] = $mailData['id']++;

        $letter = $mailData['letter'];

        $stmt = $pdo->prepare("INSERT INTO mail(letter) 
        VALUES (?)");
        $stmt->execute(array($letter));

        $this->sendToBot($letter);

        return new Mail($mailData);
    }

    public function sendToBot(string $letter)
    {
        $host = 'rattlesnake-01.rmq.cloudamqp.com';
        $port = 5672;
        $user = 'dfyszgdv';
        $password = 'mHBW0QgceZN0G5xtSUOCOOOsGTNfjW6V';
        $vhost = 'dfyszgdv';

        // Initiated connection to CloudAMQP
        $conn = new AMQPStreamConnection($host, 5672, $user, $password, $vhost);
        $channel = $conn->channel();

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
    }

}