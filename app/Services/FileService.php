<?php

namespace App\Services;
use Storage;
use Carbon\Carbon;

class FileService
{
    public static function getStorageDisk(){
        if (env('APP_ENV') == "production"){
            $disk = 'gcs';
            //$disk = Storage::disk('gcs');
        }
        else{
            $disk = 'public';
            //$disk = Storage::disk('public');
        }

        return $disk;
    }

    public static function downloadFile($filename){
        if(self::getStorageDisk() == 'public'){
            return self::forceLocalDownload($filename);
        }else{
            return self::getStorageObjectUrlSigned($filename);
        }

    }

    private static function forceLocalDownload($filename){
        if (Storage::disk('public')->exists($filename)) {
            $filePath = Storage::disk('public')->path($filename);
            return response()->download($filePath);
        }
    }


    public static function getStorageObjectUrlSigned(string $objectName)
    {
        $filename = 'ticketing-siae-69d7632c4349.json';
        $storage = new \Google\Cloud\Storage\StorageClient([
            'keyFile' => json_decode(Storage::disk('local')->get($filename),true),
        ]);

        $objectName = str_replace("https://ticketing-siae.ew.r.appspot.com/static","",$objectName);
        $bucket = $storage->bucket(env('GOOGLE_CLOUD_STORAGE_BUCKET'));
        $object = $bucket->object($objectName);
        $url = $object->signedUrl(
            new \DateTime('15 min'),
            [
                'version' => 'v4',
            ]
        );

        return $url;
    }

}
