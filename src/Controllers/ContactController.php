<?php

namespace App\Controllers;

use App\Models\Message;
use App\ReCaptcha;
use DiscordWebhooks\Client;
use DiscordWebhooks\Embed;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Validator\Validator;

class ContactController extends Controller
{
    public function contact(ServerRequestInterface $request, ResponseInterface $response)
    {
        $validator = new Validator($request->getParsedBody());
        $validator->required('name', 'email', 'subject', 'content', 'code');
        $validator->notEmpty('name', 'email', 'subject', 'content', 'code');
        $validator->email('email');
        $validator->length('name', 4, 254);
        $validator->length('subject', 4, 254);
        $validator->length('content', 8);
        if (!$validator->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ], 400);
        }
        $reCaptcha = $this->container->get(ReCaptcha::class);
        if ($reCaptcha->validate($validator->getValue('code')) === false) {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    'Invalid ReCaptcha code'
                ]
            ], 400);
        }

        //save in db
        $this->loadDatabase();
        $message = new Message();
        $message['id'] = uniqid();
        $message['author_email'] = $validator->getValue('email');
        $message['subject'] = htmlspecialchars($validator->getValue('subject'));
        $message['content'] = htmlspecialchars($validator->getValue('content'));
        $message['author_name'] = htmlspecialchars($validator->getValue('name'));
        $message['author_user_agent'] = htmlspecialchars($request->getServerParams()['HTTP_USER_AGENT']);
        $message['author_ip'] = $request->getAttribute('ip_address');
        $message->save();

        //send webhook
        $this->container->get(Client::class)
            ->embed((new Embed())
                ->color('2980b9')
                ->thumbnail("https://werobot.fr/android-icon-96x96.png")
                ->title("New message from WeRobot website")
                ->field('Subject', $message['subject'])
                ->field('Username', $message['author_name'])
                ->field('Email', $message['author_email'])
                ->field('User agent', $message['author_user_agent'])
                ->field('Ip address', $message['author_ip'])
            )->send();

        return $response->withJson([
            'success' => true
        ]);
    }
}
