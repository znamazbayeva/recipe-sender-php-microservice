<?php

namespace Zhuldyz\RecipeSenderPhpMicroservice\controller;

use Slim\Http\Response;
use Slim\Http\ServerRequest;
use Slim\Views\Twig;
use Zhuldyz\RecipeSenderPhpMicroservice\internal\repo\MailRepo;

class MailController
{
    public function index(ServerRequest $request, Response $response)
    {
        $mailRepo = new MailRepo();
        $mails = $mailRepo->getAll();

        $view = Twig::fromRequest($request);

        return $view->render($response, 'mail.twig', ['mails' => $mails]);
    }

    public function newMail(ServerRequest $request, Response $response)
    {
        $view = Twig::fromRequest($request);

        return $view->render($response, 'new.twig');
    }

    public function create(ServerRequest $request, Response $response)
    {
        $repo = new MailRepo();
        $mailData = $request->getParsedBodyParam('mail', []);

        $repo->create($mailData);

        return $response->withRedirect('/mails');
    }
}
