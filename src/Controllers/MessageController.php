<?php

namespace App\Controllers;

use App\Auth\Session;
use App\Models\Message;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Validator\Validator;

class MessageController extends Controller
{

    public function getMany(ServerRequestInterface $request, Response $response)
    {
        $this->loadDatabase();
        $validator = new Validator($request->getQueryParams());
        $validator->notEmpty('limit');
        $validator->integer('limit');
        if (!$validator->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ], 400);
        }
        if ($validator->getValue('limit') != NULL) {
            $limit = $validator->getValue('limit');
        } else {
            $limit = 15;
        }

        return $response->withJson([
            'success' => true,
            'data' => [
                'posts' => Message::query()
                    ->orderBy('created_at', 'desc')
                    ->limit($limit)
                    ->get()
                    ->toArray()
            ]
        ]);
    }

    public function getOne($id, Response $response)
    {
        $this->loadDatabase();
        $message = Message::query()->find($id);
        if ($message == NULL) {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    'Unknown message'
                ]
            ], 404);
        }
        return $response->withJson([
            'success' => true,
            'data' => [
                'message' => $message->toArray()
            ]
        ]);
    }

    public function destroy($id, Response $response, Session $session)
    {
        $this->loadDatabase();
        $post = Message::query()->find($id);
        if ($post == NULL) {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    'Unknown message'
                ]
            ], 404);
        }

        Message::destroy($id);

        return $response->withJson([
            'success' => true
        ]);
    }
}