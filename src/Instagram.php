<?php

namespace App;

use GuzzleHttp\Client;

class Instagram
{
    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var string
     */
    private $endpoint = "https://api.instagram.com/v1";

    /**
     * @var Client
     */
    private $client;

    public function __construct(string $accessToken)
    {
        $this->client = new Client();
        $this->accessToken = $accessToken;
    }

    public function getMedias()
    {
        $response = $this->client->get($this->endpoint . '/users/self/media/recent?access_token=' . $this->accessToken);
        if ($response->getStatusCode() === 200) {
            $data = json_decode($response->getBody()->getContents(), true);
            return array_map(function ($item) {
                $dateTime = (new \DateTime("@{$item['created_time']}"))->format('Y-m-d H:i:s');
                return [
                    'id' => $item['id'],
                    'caption' => $item['caption']['text'],
                    'link' => $item['link'],
                    'images' => [
                        'thumbnail' => $item['images']['thumbnail']['url'],
                        'low' => $item['images']['low_resolution']['url'],
                        'standard' => $item['images']['standard_resolution']['url'],
                    ],
                    'created_at' => $dateTime,
                ];
            }, $data['data']);
        }
        return [];
    }
}