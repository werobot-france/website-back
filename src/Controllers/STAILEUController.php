<?php

namespace App\Controllers;

use App\Auth\Session;
use App\Models\User;
use Carbon\Carbon;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use STAILEUAccounts\Client;
use Validator\Validator;

class STAILEUController extends Controller
{
    public function getLogin(Response $response, Client $STAILEUAccounts)
    {
        $url = $STAILEUAccounts->getAuthorizeUrl($this->container->get('staileu')['redirect'], [
            Client::SCOPE_READ_PROFILE,
            Client::SCOPE_READ_EMAIL
        ]);
        return $response->withJson([
            'success' => true,
            'data' => [
                'url' => $url
            ]
        ]);
    }

    public function execute(ServerRequestInterface $request, Response $response, Client $STAILEUAccounts, Session $session)
    {
        $this->loadDatabase();
        if ($request->getMethod() == 'POST'){
            $validator = new Validator($request->getParsedBody());
        }else{
            $validator = new Validator($request->getQueryParams());
        }
        $validator->required('code');
        $validator->notEmpty('code');
        if ($validator->isValid()) {
            if ($STAILEUAccounts->verify($validator->getValue('code'))) {
                $STAILUser = $STAILEUAccounts->fetchUser();
                $user = User::query()->find($STAILUser->id);
                if ($user == NULL) {
                    $user = new User();
                    $user['id'] = $STAILUser->id;
                }
                $username = $STAILUser->username;
                $email = $STAILUser->email;
                $avatar = $STAILUser->avatarUrl;
                $user['last_login_at'] = Carbon::now();
                $user['last_user_agent'] = $request->getServerParams()['HTTP_USER_AGENT'];
                $user['last_ip'] = $request->getAttribute('ip_address');
                $user['last_avatar'] = $avatar;
                $user['last_email'] = $email;
                $user['last_username'] = $username;
                if ($STAILUser->id == $this->container->get('default_admin_user_id')){
                    $user['is_admin'] = true;
                }
                $user->save();
                //generate a token and save it into cookie
                $userData = [
                    'id' => $STAILUser->id,
                    'email' => $email,
                    'avatar' => $avatar,
                    'username' => $username,
                    'is_admin' => (bool) $user['is_admin']
                ];
                $token = $session->create($userData);
                return $response->withJson([
                    'success' => true,
                    'data' => [
                        'token' => $token,
                        'user' => $userData
                    ]
                ]);
            } else {
                return $response->withJson([
                    'success' => false,
                    'errors' => [
                        'Error with STAIL.EU'
                    ]
                ])->withStatus(400);
            }
        } else {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ])->withStatus(400);
        }
    }

    public function getInfo(Response $response, Session $session){
        return $response->withJson([
           "success" => true,
           "data" => $session->getData()
        ]);
    }
}
