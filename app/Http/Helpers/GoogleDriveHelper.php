<?php

namespace App\Http\Helpers;

use App\Services\FileService;


Use \Storage;

class GoogleDriveHelper
{

    static function saveOrUpdateFile($file, $fileName, $path)
    {
        $fileName = Functions::getValidFileName($fileName);

        $ext = $file->getClientOriginalExtension();
        $url = FileService::loadStorageFiles($file,$path,$fileName.".".$ext);

        return $url;
    }

    static function saveOrUpdateFileData($file, $fileName, $path)
    {

        $base64_str = substr($file, strpos($file, ",") + 1);
        $imageContent = base64_decode($base64_str);
        $ext = 'jpg';
        $url = FileService::loadBase64StorageFiles($file,$path,$fileName.".".$ext);

        return $url;
    }
}
