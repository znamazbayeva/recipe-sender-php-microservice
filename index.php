<?php

require_once __DIR__ . './vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Zhuldyz\RecipeSenderPhpMicroservice\controller\MailController;

$twig = Twig::create(__DIR__ . './templates', ['cache' => false]);
$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);
$app->add(TwigMiddleware::create($app, $twig));


$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->get('/mails',MailController::class . ':index');
$app->get('/mails/new',MailController::class . ':newMail');
$app->post('/mails',MailController::class . ':create');

$app->run();