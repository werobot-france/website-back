<?php

namespace App\Controllers;

use App\Models\Message;
use App\Models\Post;
use Carbon\Carbon;
use Lefuturiste\LocalStorage\LocalStorage;
use Psr\Http\Message\ResponseInterface;

class BackupController extends Controller
{
    public function getMany($_, ResponseInterface $response)
    {
        $backups = $this->localStorage()->get('backups');
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

    public function getOne($_, ResponseInterface $response, array $args)
    {
        $id = $args['id'];
        $backup = array_filter($this->localStorage()->get('backups'), function ($item) use ($id) {
            return $item['id'] === $id;
        });

        return $response->withJson([
            'success' => true,
            'data' => [
                'backup' => $backup
            ]
        ]);
    }

    public function create($_, ResponseInterface $response)
    {
        $this->loadDatabase();
        $backups = $this->localStorage()->get('backups');
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
        $this->localStorage()->set('backups', $backups);
        $this->localStorage()->save();

        return $response->withJson([
            'success' => true,
            'data' => [
                'backup' => $backup
            ]
        ]);
    }
}
