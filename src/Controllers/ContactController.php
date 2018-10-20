<?php

namespace App\Controllers;

use App\Models\Message;
use App\ReCaptcha;
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

        return $response->withJson([
            'success' => true
        ]);
    }
}