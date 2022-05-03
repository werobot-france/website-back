<?php

namespace App\Controllers;

use DateTime;
use FeedIo\Factory;
use FeedIo\Feed;
use FeedIo\Feed\Item;
use FeedIo\FeedIo;
use FeedWriter\ATOM;
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
use Psr\Http\Message\ResponseInterface;

class FeedController extends Controller
{

    public function getFeed(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->loadDatabase();
        $validator = new Validator($request->getQueryParams());
        $validator->notEmpty('locale', 'limit', 'format');
        $validator->integer('limit');

        if (!$validator->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ], 400);
        }

        $query = Post::query()
            ->select(['id', 'title', 'locale', 'slug', 'identifier', 'description', 'image', 'created_at', 'updated_at'])
            ->orderBy('created_at', 'desc');

        $limit = $validator->getValue('limit') ?? 25;
        $query->limit($limit);

        $locale = $validator->getValue('locale') ?? 'en';
        $query = $query->where('locale', '=', $locale);

        $format = $validator->getValue('format') ?? 'json';

        $posts = $query->get()->toArray();

        $feed = new Feed();
        if ($locale == 'en') {
            $feed->setTitle("We Robot's blog")->setLink("https://werobot.fr/blog");
        }
        if ($locale == 'fr') {
            $feed->setTitle("Le blog de We Robot")->setLink("https://werobot.fr/blog");
        }

        foreach ($posts as $post) {
            $item = new Item();
            $item->setTitle($post['title']);
            $item->setPublicId($post['id']);
            $item->setSummary($post['description']);
            $item->setLastModified(Carbon::createFromTimeString($post['updated_at']));
            $item->setLink($this->container->get('frontend_base_url') . '/blog/' . $post['slug']);
            $mediaUrl = $post['image'];
            $ext = pathinfo($mediaUrl, PATHINFO_EXTENSION);
            $mimeType = '';
            if ($ext == 'png') {
                $mimeType = 'image/png';
            }
            if ($ext == 'jpg' || $ext == 'jpeg') {
                $mimeType = 'image/jpeg';
            }
            $item->addMedia(
                (new Item\Media())
                    ->setUrl($mediaUrl)
                    ->setType($mimeType)
            );
            $feed->add($item);
        }

        try {
            return (Factory::create()->getFeedIo())->getPsrResponse($feed, $format);
        } catch (\OutOfRangeException $e) {
            return $response->withStatus(400)->withJson([
                'success' => false,
                'errors' => [['type' => 'unknown-feed-format', 'message' => "Invalid format"]]
            ]);
        }

        //$jsonResponse = $feedIo->getPsrResponse($feed, 'json');
    }


}
