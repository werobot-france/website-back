<?php

namespace App;

use Gumlet\ImageResize;

class ImageHelper {
    public static function import(string $absolutePath)
    {
        // generate 3 differents size in a folder
        $image = new ImageResize($absolutePath);
        $image->gamma(false);
        $image->scale(75);
        $image->save(str_replace('original', '75', $absolutePath));
        $image->scale(50);
        $image->save(str_replace('original', '50', $absolutePath));
        $image->scale(25);
        $image->save(str_replace('original', '25', $absolutePath));
    }

    public static function MIMETypeToExtension(string $MIMEType)
    {
        $attrs = [
            'image/jpeg' => 'jpg',
            'image/gif' => 'gif',
            'image/png' => 'png'
        ];
        return isset($attrs[$MIMEType]) ? $attrs[$MIMEType] : NULL;
    }
}
