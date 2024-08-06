<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Google\Cloud\Storage\StorageClient;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class ModifyAssetUrls
{
    public function handle($request, Closure $next)
    {
        Log::info('Request URL: ' . $request->fullUrl());
        $response = $next($request);

        //if ($response instanceof SymfonyResponse) {
            $path = $request->path();

            //if ($response->headers->get('Content-Type') === 'text/html; charset=UTF-8') {
                $content = $response->getContent();

                $assetBaseUrl = 'http://mims-siae.test';
                // $assetBaseUrl = 'https://ticketing-siae.ew.r.appspot.com';

                $patterns = [
                    '/' . preg_quote($assetBaseUrl, '/') . '[^\s\'"<>]*/',
                    '/(' . preg_quote($assetBaseUrl, '/') . '\/static\/css\/[^\s\'"<>]*)/',
                    '/(' . preg_quote($assetBaseUrl, '/') . '\/static\/js\/[^\s\'"<>]*)/',
                    '/(' . preg_quote($assetBaseUrl, '/') . '\/static\/images\/[^\s\'"<>]*)/',
                ];


                // Replace the matched URLs with signed URLs
                foreach ($patterns as $pattern) {
                    Log::info(preg_match_all($pattern, $content, $matches));
                    //Log::info('RESPONSE : ', [$response->getContent()]);
                    Log::info("\n\n\n\n");
                    $content = preg_replace_callback($pattern, function ($matches) {
                        Log::info('URL trovato:', ['url' => $matches[0]]);
                        $signedUrl = $this->getStorageObjectUrlSigned($matches[0]);
                        // Log::info('URL firmato sostituito:', ['url' => $signedUrl]);
                        return $signedUrl;
                    }, $content);
                }

                //Log::info('Response:', [$response]);
                $response->setContent($content);
            //}
        //}

        return $response;
    }

    /**
     * Get a signed URL for a storage object
     */
    public static function getStorageObjectUrlSigned(string $objectUrl)
    {
        $filename = 'ticketing-siae-69d7632c4349.json';

        // Create a new StorageClient with the credentials
        $storage = new StorageClient([
            'keyFile' => json_decode(Storage::disk('local')->get($filename), true),
        ]);

        // Parse the URL to get the path
        $parsedUrl = parse_url($objectUrl);
        $objectPath = ltrim($parsedUrl['path'], '/');

        // Get the bucket and object
        $bucket = $storage->bucket(env('GOOGLE_CLOUD_STORAGE_BUCKET'));
        $object = $bucket->object($objectPath);

        // Generate a signed URL valid for 15 minutes
        $url = $object->signedUrl(
            new \DateTime('15 min'),
            [
                'version' => 'v4',
            ]
        );

        return $url;
    }
}
