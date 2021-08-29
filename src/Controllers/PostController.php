<?php

namespace App\Controllers;

use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use App\Auth\Session;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Lefuturiste\LocalStorage\LocalStorage;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Validator\Validator;

class PostController extends Controller
{

    public function getYears(ServerRequestInterface $request, Response $response, LocalStorage $localStorage)
    {
        $this->loadDatabase();
        $validator = new Validator($request->getQueryParams());
        $validator->notEmpty('locale');
        if (!$validator->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ], 400);
        }
        $locale = $validator->getValue('locale');
        if ($localStorage->exist("posts-by-year.locale.{$locale}")) {
            $years = $localStorage->get("posts-by-year.locale.{$locale}");
        } else {
            $query = Post::query()
                ->select(['id', 'title', 'locale', 'slug', 'identifier', 'description', 'image', 'created_at', 'updated_at'])
                ->orderBy('created_at', 'desc');

            if ($locale !== null) {
                $query = $query->where('locale', '=', $locale);
            }
            $posts = $query->get()->toArray();
            $years = [];
            foreach ($posts as $post) {
                $carbon = Carbon::createFromTimeString($post['created_at']);
                $year = $carbon->year;
                if (!isset($years[$year])) {
                    $years[$year] = ['name' => $year, 'count' => 0];
                }
                $years[$year]['count'] = $years[$year]['count'] + 1;
            }
            $years = array_values($years);
            $localStorage->set("posts-by-year.locale.{$locale}", $years);
            $localStorage->write();
        }
        return $response->withJson([
            'success' => true,
            'data' => [
                'years' => $years
            ]
        ]);
    }

    public function getDates(ServerRequestInterface $request, Response $response, LocalStorage $localStorage)
    {
        $this->loadDatabase();
        $validator = new Validator($request->getQueryParams());
        $validator->notEmpty('locale');
        if (!$validator->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ], 400);
        }
        $locale = $validator->getValue('locale');
        if ($localStorage->exist("posts-by-dates.locale.{$locale}")) {
            $categoriesDates = $localStorage->get("posts-by-dates.locale.{$locale}");
        } else {
            $query = Post::query()
                ->select(['id', 'title', 'locale', 'slug', 'identifier', 'description', 'image', 'created_at', 'updated_at'])
                ->orderBy('created_at', 'desc');

            if ($locale !== null) {
                $query = $query
                    ->where('locale', '=', $locale);
            }
            $posts = $query->get()->toArray();
            $categoriesDates = [];
            foreach ($posts as $post) {
                $carbon = Carbon::createFromTimeString($post['created_at']);
                $year = $carbon->year;
                $month = $carbon->month;
                $hash = $year . '-' . $month;
                $categoriesDates[$hash][] = $post;
            }
            $localStorage->set("posts-by-dates.locale.{$locale}", $categoriesDates);
            $localStorage->write();
        }
        return $response->withJson([
            'success' => true,
            'data' => $categoriesDates
        ]);
    }

    public function getMany(ServerRequestInterface $request, Response $response)
    {
        $this->loadDatabase();
        $validator = new Validator($request->getQueryParams());
        $validator->notEmpty('locale', 'limit', 'per_page', 'page', 'identifier', 'year');
        $validator->integer('limit', 'page', 'per_page', 'year');
        if (!$validator->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ], 400);
        }

        $query = Post::query()
            ->select(['id', 'title', 'locale', 'slug', 'identifier', 'description', 'image', 'created_at', 'updated_at'])
            ->orderBy('created_at', 'desc');

        if ($validator->getValue('limit') !== null) {
            $query = $query->limit($validator->getValue('limit'));
        }

        if ($validator->getValue('locale') !== null) {
            $query = $query->where('locale', '=', $validator->getValue('locale'));
        }
        if ($validator->getValue('identifier') !== null) {
            $query = $query->where('identifier', '=', $validator->getValue('identifier'));
        }

        $year = $validator->getValue('year');
        if ($year !== null) {
            $query = $query->whereBetween('created_at', [date($year . '-01-01'), date($year . '-12-31')]);
        }

        $maxPerPage = intval(isset($request->getQueryParams()['per_page']) ? $request->getQueryParams()['per_page'] : null);

        $currentPage = intval(isset($request->getQueryParams()['page']) && $request->getQueryParams()['page'] > 0 ? $request->getQueryParams()['page'] : 1);
        
        if ($maxPerPage != null) {
            $res = $query->paginate($maxPerPage, ['*'], 'page', $currentPage)->toArray();
            $pagination = [
                'total_page' => $res['last_page'],
                'per_page' => $res['per_page'],
                'result_count' => $res['total'],
                'current_page' => $res['current_page'],
                'previous_page' => $res['prev_page_url'] === null ? null : intval(substr($res['prev_page_url'], 7)),
                'next_page' => $res['next_page_url'] === null ? null : intval(substr($res['next_page_url'], 7)),
            ];
            $data = $res['data'];
        } else {
            $pagination = [];
            $data = $query->get()->toArray();
        }
        
        return $response->withJson([
            'success' => true,
            'data' => [
                'posts' => $data,
                'pagination' => $pagination
            ]
        ]);
    }

    public function getOne($id, Response $response)
    {
        $this->loadDatabase();
        $post = Post::query()->find($id);
        if ($post == NULL) {
          $post = Post::query()->where('slug', '=', $id)->first();
          if ($post == NULL) {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    'Unknown post'
                ]
            ], 404);
          }
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
        $validator->required('title', 'content', 'image', 'locale');
        $validator->notEmpty('title', 'description', 'content', 'image', 'locale', 'identifier', 'created_at');
        $validator->url('image');
        $validator->dateTime('created_at');
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
        $post['description'] = $validator->getValue('description') == NULL ? substr($validator->getValue('content'), 0, 150) : $validator->getValue('description');
        $post['content'] = $validator->getValue('content');
        $post['locale'] = $validator->getValue('locale');
        $post['identifier'] = $validator->getValue('identifier') == NULL ? uniqid() : $validator->getValue('identifier');
        $post['created_at'] = $validator->getValue('created_at') == NULL ? (new Carbon())->toDateTimeString() : $validator->getValue('created_at');
        if (isset($session->getData()['user']['id'])) {
            $post->user()->associate($session->getUserId());
        }
        $post->save();
        return $response->withJson([
            'success' => true,
            'data' => [
                'post' => $post->toArray()
            ]
        ]);
    }

    public function update($id, ServerRequestInterface $request, Response $response)
    {
        $validator = new Validator($request->getParsedBody());
        $validator->notEmpty('title', 'description', 'content', 'image', 'created_at');
        $validator->url('image');
        $validator->dateTime('created_at');
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

        $post['title'] = $validator->getValue('title') === NULL ? $post['title'] : $validator->getValue('title');
        $post['slug'] = $validator->getValue('title') === NULL ? $post['slug'] : str_slug($validator->getValue('title'));
        $post['image'] = $validator->getValue('image') === NULL ? $post['image'] : $validator->getValue('image');
        $post['description'] = $validator->getValue('content') === NULL ? $post['description'] : ($validator->getValue('description') == NULL ? substr($validator->getValue('content'), 0, 150) : $validator->getValue('description'));
        $post['content'] = $validator->getValue('content') === NULL ? $post['content'] : $validator->getValue('content');
        $post['created_at'] = $validator->getValue('created_at') == NULL ? $post['created_at'] : $validator->getValue('created_at');
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

    public function destroy($id, Response $response)
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
