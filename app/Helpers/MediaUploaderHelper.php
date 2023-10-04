<?php

namespace App\Helpers;

use Plank\Mediable\Facades\MediaUploader;

class MediaUploaderHelper
{
    public static function upload($media, $directory)
    {
        return  MediaUploader::fromSource($media)
            ->toDirectory($directory)
            ->upload();
    }
}
