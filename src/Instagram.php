<?php

namespace App;

class Instagram
{
    public function getMedias()
    {
        $instagram = new \InstagramScraper\Instagram();
        $medias = [];
        foreach ($instagram->getMedias('werobot') as $media) {
            $dateTime = (new \DateTime("@{$media->getCreatedTime()}"))->format('Y-m-d H:i:s');
            array_push($medias, [
                'id' => $media->getId(),
                'caption' => $media->getCaption(),
                'link' => $media->getLink(),
                'images' => [
                    'thumbnail' => $media->getImageThumbnailUrl(),
                    'low' => $media->getImageLowResolutionUrl(),
                    'standard' => $media->getImageStandardResolutionUrl(),
                    'high' => $media->getImageHighResolutionUrl()
                ],
                'created_at' => $dateTime,
            ]);
        }
        return $medias;
    }
}