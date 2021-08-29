<?php
require 'vendor/autoload.php';

if (!isset($argv[1]) || $argv[1] === '') {
    echo "You must provide a auth token at argv 1 \n";
    exit();
}
$token = $argv[1];

$client = new GuzzleHttp\Client([
    'http_errors' => false,
    'headers' => [
        'Authorization' => 'Bearer ' . $token
    ]
]);

$response = $client->get('https://api.werobot.fr/backup/5c3e21a4bafee');
$body = json_decode($response->getBody()->getContents(), 1);

foreach ($body['data']['backup']['2']['data']['posts'] as $post) {
    echo "> Now migrating: " . $post['id'] . " \n";

    $response = $client->get("https://api.werobot.fr/post/" . $post['id']);
    $body = json_decode($response->getBody()->getContents(), 1);
    if ($body['data']['post']['description'] === "") {
        $response = $client->put('https://api.werobot.fr/post/' . $post['id'], [
            'json' => [
                'description' => $post['description']
            ]
        ]);
        if ($response->getStatusCode() === 200) {
            echo ".    > updated post description \n";
        }
    } else {
        echo ".    > post already have a description \n";
    }
}
