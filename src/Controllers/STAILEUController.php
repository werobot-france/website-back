<?php

namespace App\Controllers;

use App\Auth\Session;
use App\Models\User;
use Carbon\Carbon;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use STAILEUAccounts\STAILEUAccounts;
use Validator\Validator;

class STAILEUController extends Controller
{
    public function getLogin(Response $response, STAILEUAccounts $STAILEUAccounts)
    {
        $url = $STAILEUAccounts->loginForm($this->container->get('staileu')['redirect']);
        return $response->withJson([
            'success' => true,
            'data' => [
                'url' => $url
            ]
        ]);
    }

    public function execute(ServerRequestInterface $request, Response $response, STAILEUAccounts $STAILEUAccounts, Session $session)
    {
        $this->loadDatabase();
        if ($request->getMethod() == 'POST'){
            $validator = new Validator($request->getParsedBody());
        }else{
            $validator = new Validator($request->getQueryParams());
        }
        $validator->required('c-sa');
        $validator->notEmpty('c-sa');
        if ($validator->isValid()) {
            $result = $STAILEUAccounts->check($validator->getValue('c-sa'));
            if (is_string($result)) {
                $user = User::query()->find($result);
                if ($user == NULL) {
                    $user = new User();
                    $user['id'] = $result;
                }
                $username = $STAILEUAccounts->getUsername($result);
                $email = $STAILEUAccounts->getEmail($result);
                $avatar = $STAILEUAccounts->getAvatar($result)->getUrl();
                $user['last_login_at'] = Carbon::now();
                $user['last_user_agent'] = $request->getServerParams()['HTTP_USER_AGENT'];
                $user['last_ip'] = $request->getAttribute('ip_address');
                $user['last_avatar'] = $avatar;
                $user['last_email'] = $email;
                $user['last_username'] = $username;
                if ($result == $this->container->get('default_admin_user_id')){
                    $user['is_admin'] = true;
                }
                $user->save();
                //generate a token and save it into cookie
                $userData = [
                    'id' => $result,
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
                        $result->getCode() . ": " . $result->getMessage()
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
