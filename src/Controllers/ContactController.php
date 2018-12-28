<?php

namespace App\Controllers;

use App\Models\Message;
use App\ReCaptcha;
use DiscordWebhooks\Client;
use DiscordWebhooks\Embed;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Validator\Validator;

class ContactController extends Controller
{
    public function contact(ServerRequestInterface $request, Response $response, ReCaptcha $reCaptcha)
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

        //send a mailgun email
//        $mailGunClient = $this->container->get(Mailgun::class);
//        $mailGunClient->messages()->send('lefuturiste.fr', [
//            'from' => "We Robot Contact Form <contact-form@werobot.fr>",
//            'to' => $this->container->get('mailgun')['to'],
//            'subject' => $message['subject'] . ' - Contact Form',
//            'text' => `
//            Hey!
//            There was a new message sent from the WeRobot's wesite.
//
//            from: {$message['author_name']} <{$message['author_email']}>
//            ip: {$message['author_ip']}
//            user-agent: {$message['author_user_agent']}
//            subject: {$message['subject']}
//            ----- TEXT BEGIN -----
//
//            {$message['content']}
//
//            ----- TEXT   END -----
//            `
//        ]);

        return $response->withJson([
            'success' => true
        ]);
    }
}
