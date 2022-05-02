<?php

namespace App\Controllers;

use App\Auth\Session;
use App\Models\User;
use Google\Auth\Credentials\UserRefreshCredentials;
use Google\Auth\OAuth2;
use Google\Photos\Library\V1\PhotosLibraryClient;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use SlimSession\Helper;
use Validator\Validator;

class GoogleController extends Controller
{
    public function authorize(Response $response)
    {
        $googleOAuth = $this->container->get(OAuth2::class);
        return $response->withJson([
            'success' => true,
            'data' => [
                'url' => $googleOAuth->buildFullAuthorizationUri(['access_type' => 'offline'])->__toString()
            ]
        ]);
    }

    public function execute(ServerRequestInterface $request, Response $response, Session $session)
    {
        $validator = new Validator($request->getParsedBody());
        $validator->required('code');
        $validator->notEmpty('code');
        if (!$validator->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ]);
        }
        $this->loadDatabase();
        $user = User::query()->find($session->getUserId());
        if ($user === NULL) {
            return $response->withJson(['success' => false, 'errors' => ['Unknown account']]);
        }
        $googleResponse = (new \GuzzleHttp\Client())
            ->post('https://www.googleapis.com/oauth2/v4/token', [
                'form_params' => [
                    'client_id' => $this->container->get('google')['client_id'],
                    'client_secret' => $this->container->get('google')['client_secret'],
                    'grant_type' => 'authorization_code',
                    'code' => $validator->getValue('code'),
                    'redirect_uri' => $this->container->get('google')['redirection_url']
                ],
                'http_errors' => false
            ]);
        if ($googleResponse->getStatusCode() !== 200) {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    'invalid-google-response' => [
                        'code' => $googleResponse->getStatusCode(),
                        'detail' => $googleResponse->getBody()->getContents()
                    ]
                ]
            ], 400);
        }

        $body = json_decode($googleResponse->getBody()->getContents(), true);
        $googleResponse = (new \GuzzleHttp\Client())
            ->get("https://www.googleapis.com/oauth2/v1/userinfo?alt=json&access_token={$body['access_token']}", ['http_errors' => false]);
        $detailsBody = json_decode($googleResponse->getBody()->getContents(), true);

        /*$googleOAuth = $this->container->get(OAuth2::class);
        $googleOAuth->setCode();
        try {
            $authToken = $googleOAuth->fetchAuthToken();
        } catch (\Exception $exception) {
            var_dump($exception);
            die();
        }*/
        $user['google_id'] = $detailsBody['id'];
        $user['google_refresh_token'] = $body['access_token'];
        $user->save();

        return $response->withJson([
            'success' => true,
            'data' => [
                'body' => $body,
                'details' => $detailsBody
            ]
        ]);
    }

/*    public function getAlbums(Response $response)
    {
        $photosLibraryClient = $this->loadSession();
        if ($photosLibraryClient == false) {
            return $response->withJson(['success' => false], 400);
        }
        $albumsResponse = $photosLibraryClient->listAlbums();
        $albums = [];
        foreach ($albumsResponse->iterateAllElements() as $album) {
            // Get some properties of an album
            $albums[] = [
                'id' => $album->getId(),
                'title' => $album->getTitle(),
                'image' => $album->getCoverPhotoBaseUrl()
            ];
        }
        return $response->withJson([
            'success' => true,
            'data' => ['albums' => $albums]
        ]);
    }*/

    public function getAllAlbums(Response $response)
    {
        $this->loadDatabase();
        $user = User::query()->find($this->session()->getUserId());
        if ($user === null) {
            return $response->withJson([
                'success' => false,
                'errors' => ['unknown_user']
            ], 400);
        }
        if ($user['google_id'] === null || $user['google_refresh_token'] === null) {
            return $response->withJson([
                'success' => false,
                'errors' => ['not_linked']
            ], 400);
        }
        $photosLibraryClient = $this->loadSession($user['google_refresh_token']);
        if ($photosLibraryClient == false) {
            return $response->withJson(['success' => false], 400);
        }

        $sharedAlbums = [];
        try {
            $sharedAlbumsResponse = $photosLibraryClient->listSharedAlbums();
        } catch (\Exception $e) {
            return $response->withJson([
                'success' => false,
                'errors' => ["Can't fetch shared albums"]
            ], 400);
        }

        foreach ($sharedAlbumsResponse->iterateAllElements() as $album) {
            // Get some properties of an album
            $sharedAlbums[] = [
                'id' => $album->getId(),
                'title' => $album->getTitle(),
                'image' => $album->getCoverPhotoBaseUrl()
            ];
        }

        $albums = [];
        $albumsResponse = $photosLibraryClient->listAlbums();
        foreach ($albumsResponse->iterateAllElements() as $album) {
            // Get some properties of an album
            $albums[] = [
                'id' => $album->getId(),
                'title' => $album->getTitle(),
                'image' => $album->getCoverPhotoBaseUrl()
            ];
        }
        return $response->withJson([
            'success' => true,
            'data' => ['shared_albums' => $sharedAlbums, 'albums' => $albums]
        ]);
    }


    public function getAlbum(string $id, Response $response)
    {
        $photosLibraryClient = $this->loadSession();
        if ($photosLibraryClient == false) {
            return $response->withJson(['success' => false], 400);
        }

        $medias = [];
        $albumResponse = $photosLibraryClient->searchMediaItems(['albumId' => $id]);
        foreach ($albumResponse->iterateAllElements() as $media) {
            $medias[] = [
                'id' => $media->getId(),
                'mime_type' => $media->getMimeType(),
                'product_url' => $media->getProductUrl()
            ];
        }
        return $response->withJson([
            'success' => true,
            'data' => ['album_items' => $albumResponse]
        ]);
    }

    public function loadSession(string $refreshToken)
    {
        $creds = $this->getCredentials($refreshToken);
        try {
            $creds->fetchAuthToken();
        } catch (\Exception $e) {
            $creds = $this->getCredentials($refreshToken);
        }
        return new PhotosLibraryClient(['credentials' => $creds]);
    }

    public function getCredentials(string $refreshToken)
    {
        return new UserRefreshCredentials(
            $this->container->get('google')['scope'],
            [
                'client_id' => $this->container->get('google')['client_id'],
                'client_secret' => $this->container->get('google')['client_secret'],
                'refresh_token' => $refreshToken
            ]
        );
    }
}
