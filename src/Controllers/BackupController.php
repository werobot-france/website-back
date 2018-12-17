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
        $backups = $localStorage->get('backups');
        $backups = $backups === NULL ? [] : $backups;
        $backups = array_map(function ($backup) {
            return [
                'id' => $backup['id'],
                'at' => $backup['at'],
                'checksum' => $backup['checksum']
            ];
        }, $backups);
        return $response->withJson([
            'success' => true,
            'data' => [
                'backups' => $backups
            ]
        ]);
    }

    public function getOne($id, Response $response, LocalStorage $localStorage)
    {
        $backup = array_filter($localStorage->get('backups'), function ($item) use ($id) {
            return $item['id'] === $id;
        });
        return $response->withJson([
            'success' => true,
            'data' => [
                'backup' => $backup
            ]
        ]);
    }

    public function create(Response $response, LocalStorage $localStorage)
    {
        $this->loadDatabase();
        $backups = $localStorage->get('backups');
        $backups = $backups === NULL ? [] : $backups;
        $data = [
            'posts' => Post::all(),
            'messages' => Message::all()
        ];
        $backup = [
            'id' => uniqid(),
            'at' => (new Carbon())->toDateTimeString(),
            'checksum' => hash('sha256', json_encode($data)),
            'data' => $data
        ];
        $backups[] = $backup;
        $localStorage->set('backups', $backups);
        $localStorage->save();
        return $response->withJson([
            'success' => true,
            'data' => [
                'backup' => $backup
            ]
        ]);
    }
}
