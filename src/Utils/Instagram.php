<?php

namespace App\Utils;

use Psr\Container\ContainerInterface;

class Instagram
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getMedias(): array
    {
        $bypass = $this->container->get('bypass_instagram_scraping');
        $data = null;
        $opts = [
            "http" => [
                "method" => "GET",
                "header" => "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36"
            ]
        ];
        if (!$bypass) {
            $context = stream_context_create($opts);
            $u = "https://www.instagram.com/graphql/query/?query_hash=e769aa130647d2354c40ea6a439bfc08&variables=%7B%22id%22%3A%225408546825%22,%20%22first%22%3A%2250%22,%20%22after%22%3A%20%22%22%7D";
            $json = file_get_contents($u, false, $context);
            $data = json_decode($json, true);
        }

        if ($data == null) {
            $url = $this->container->get('root_path') . '/tmp/instagram_pictures.json';
            $data = json_decode(file_get_contents($url), true);
        }

        $raw = $data['data']['user']['edge_owner_to_timeline_media']['edges'];
        $medias = [];
        foreach ($raw as $rawMedia) {
            $rawMedia = $rawMedia['node'];

            $caption = NULL;
            if (count($rawMedia['edge_media_to_caption']['edges']) > 0) {
                $caption = $rawMedia['edge_media_to_caption']['edges'][0]['node']['text'];
            }

            $medias[] = [
                'id'        => $rawMedia['id'],
                'caption'   => $caption,
                'thumbnail' => $rawMedia['thumbnail_src'],
                'original'  => $rawMedia['display_url'],
                'link'      => 'https://www.instagram.com/p/' . $rawMedia['shortcode'] . '/',
                'taken_at'  => $rawMedia['taken_at_timestamp']
            ];
        }
        return $medias;
    }
}
