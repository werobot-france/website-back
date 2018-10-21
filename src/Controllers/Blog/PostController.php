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
        $validator->notEmpty('locale', 'limit');
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
        $query = Post::query()
            ->select(['id', 'title', 'locale', 'identifier', 'description', 'image', 'created_at', 'updated_at'])
            ->orderBy('created_at', 'desc')
            ->limit($limit);

        if ($validator->getValue('locale') !== null) {
            $query = $query
                ->where('locale', '=', $validator->getValue('locale'));
        }
        return $response->withJson([
            'success' => true,
            'data' => [
                'posts' => $query->get()->toArray()
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
        $validator = new Validator($request->getParsedBody());
        $validator->required('title', 'content', 'image', 'locale', 'identifier');
        $validator->notEmpty('title', 'content', 'image', 'locale', 'identifier');
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
        $post['locale'] = $validator->getValue('locale');
        $post['identifier'] = $validator->getValue('identifier');
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

        if ($validator->getValue('locale') != NULL) {
            $post['locale'] = $validator->getValue('locale');
        }
        if ($validator->getValue('identifier') != NULL) {
            $post['identifier'] = $validator->getValue('identifier');
        }
        $post->save();

        return $response->withJson([
            'success' => true
        ]);
    }

    public function destroy($id, Response $response, Session $session)
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

        Post::destroy($id);

        return $response->withJson([
            'success' => true
        ]);
    }

}