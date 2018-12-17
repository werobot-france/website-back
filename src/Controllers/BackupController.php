<?php

namespace App\Controllers;

use App\Models\Message;
use App\Models\Post;
use Carbon\Carbon;
use Lefuturiste\LocalStorage\LocalStorage;
use Slim\Http\Response;

class BackupController extends Controller
{
    public function getMany(Response $response, LocalStorage $localStorage)
    {
        return $response->withJson([
            'success' => true,
            'data' => [
                'backups' => $localStorage->get('backups')
            ]
        ]);
    }

    public function create(Response $response, LocalStorage $localStorage)
    {
        $this->loadDatabase();
        $backups = $localStorage->get('backups');
        $backups = $backups === NULL ? [] : $backups;
        $backup = [
            'id' => uniqid(),
            'at' => (new Carbon())->toDateTimeString(),
            'data' => [
                'posts' => Post::all(),
                'messages' => Message::all()
            ]
        ];
        $backups[] = $backup;
        $localStorage->set('backups', $backups);
        return $response->withJson([
            'success' => true,
            'data' => [
                'backup' => $backup
            ]
        ]);
    }
}
