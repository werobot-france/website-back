<?php

namespace App\Controllers\Blog;

use App\Auth\Session;
use App\Controllers\Controller;
use App\Models\Post;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Validator\Validator;

class PostController extends Controller
{
    public function getMany(ServerRequestInterface $request, Response $response)
    {
        $this->loadDatabase();
        $validator = new Validator($request->getQueryParams());
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
                'posts' => Post::query()
                    ->select(['id', 'title', 'description', 'image', 'created_at', 'updated_at'])
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
        $post = Post::query()->find($id);
        if ($post == NULL) {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    'Unknown post'
                ]
            ], 404);
        }
        return $response->withJson([
            'success' => true,
            'data' => [
                'post' => $post->toArray()
            ]
        ]);
    }

    public function store(ServerRequestInterface $request, Response $response, Session $session)
    {
        if (!$session->isAdmin()) {
            return $response->withJson([
                'success' => false,
                'errors' => ['Forbidden']
            ], 403);
        }
        $validator = new Validator($request->getParsedBody());
        $validator->required('title', 'content', 'image');
        $validator->notEmpty('title', 'content', 'image');
        $validator->url('image');
        if (!$validator->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ], 400);
        }
        $this->loadDatabase();
        $post = new Post();
        $post['id'] = uniqid();
        $post['title'] = $validator->getValue('title');
        $post['slug'] = str_slug($validator->getValue('title'));
        $post['image'] = $validator->getValue('image');
        $post['description'] = substr($validator->getValue('content'), 0, 150);
        $post['content'] = $validator->getValue('content');
        $post->user()->associate($session->getUserId());
        $post->save();
        return $response->withJson([
            'success' => true,
            'data' => [
                'post' => $post->toArray()
            ]
        ]);
    }

    public function update($id, ServerRequestInterface $request, Response $response, Session $session)
    {
        if (!$session->isAdmin()) {
            return $response->withJson([
                'success' => false,
                'errors' => ['Forbidden']
            ], 403);
        }
        $validator = new Validator($request->getParsedBody());
        $validator->required('title', 'content', 'image');
        $validator->notEmpty('title', 'content', 'image');
        $validator->url('image');
        if (!$validator->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ], 400);
        }

        $this->loadDatabase();
        $post = Post::query()->find($id);
        if ($post == NULL) {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    'Unknown post'
                ]
            ], 404);
        }

        $post['title'] = $validator->getValue('title');
        $post['slug'] = str_slug($validator->getValue('title'));
        $post['image'] = $validator->getValue('image');
        $post['description'] = substr($validator->getValue('content'), 0, 150);
        $post['content'] = $validator->getValue('content');
        $post->save();

        return $response->withJson([
            'success' => true
        ]);
    }

    public function destroy($id, Response $response, Session $session)
    {
        if (!$session->isAdmin()) {
            return $response->withJson([
                'success' => false,
                'errors' => ['Forbidden']
            ], 403);
        }
        $this->loadDatabase();
        $post = Post::query()->find($id);
        if ($post == NULL) {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    'Unknown post'
                ]
            ], 404);
        }

        Post::destroy($id);

        return $response->withJson([
            'success' => true
        ]);
    }

}