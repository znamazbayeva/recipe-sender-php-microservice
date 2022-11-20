<?php

namespace Zhuldyz\RecipeSenderPhpMicroservice\internal\repo;

use PDO;
use Zhuldyz\RecipeSenderPhpMicroservice\internal\entity\Mail;

$connection = new PDO("mysql:host=localhost;dbname=mail_db","root","zhanarys");

class MailRepo
{
    private function connectDB(): PDO
    {
        $connection = new PDO("mysql:host=localhost;dbname=mail_db","root","zhanarys");
        return $connection;
    }

    public function getAll(){
        $pdo = $this->connectDB();
        $query = "SELECT * FROM mail";
        $data = $pdo->query($query)->fetchAll();

        $result = [];

        foreach ($data as $mailData){
            $result[] = new Mail($mailData);
        }

        return $result;
    }

    public function create(array $mailData): Mail {
        $pdo = $this->connectDB();

        $mailData['id'] = $mailData['id']++;

        $letter =$mailData['letter'];

        $stmt = $pdo->prepare("INSERT INTO mail(letter) 
        VALUES (?)");
        $stmt->execute(array($letter));

        return new Mail($mailData);
    }

}