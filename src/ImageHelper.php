<?php

namespace App;

use Gumlet\ImageResize;

class ImageHelper {
    public static function import(string $absolutePath)
    {
        // generate 3 differents size in a folder
        $image = new ImageResize($absolutePath);
        $image->quality_jpg = 100;
        $image->quality_png = 100;
        $image->quality_truecolor = true;
        $image->interlace = false;
        $image->scale(75);
        $image->save(str_replace('original', '75', $absolutePath));
        $image->scale(50);
        $image->save(str_replace('original', '50', $absolutePath));
        $image->scale(25);
        $image->save(str_replace('original', '25', $absolutePath));
    }

    public static function MIMETypeToExtension(string $MIMEType): string
    {
        return [
            'image/jpeg' => 'jpg',
            'image/gif' => 'gif',
            'image/png' => 'png'
        ][$MIMEType];
    }
}
