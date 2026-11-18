<?php

/*
|--------------------------------------------------------------------------
| Firebase Storage credentials
|--------------------------------------------------------------------------
|
| On serverless platforms there is no persistent, writable disk to keep the
| service account JSON file. Instead we accept the JSON as a base64 encoded
| environment variable and decode it at runtime.
|
*/

$firebaseCredentials = null;

if ($encodedCredentials = env('FIREBASE_CREDENTIALS_BASE64')) {
    $decodedCredentials = base64_decode($encodedCredentials, true);

    if ($decodedCredentials !== false) {
        $firebaseCredentials = json_decode($decodedCredentials, true) ?: null;
    }
}

$useFirebaseStorage = $firebaseCredentials && env('FIREBASE_STORAGE_BUCKET');

$publicDisk = $useFirebaseStorage
    ? [
        'driver' => 'firebase',
        'project_id' => env('FIREBASE_PROJECT_ID') ?? ($firebaseCredentials['project_id'] ?? null),
        'bucket' => env('FIREBASE_STORAGE_BUCKET'),
        'credentials' => $firebaseCredentials,
        'throw' => false,
    ]
    : [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
        'throw' => false,
    ];

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        /*
         * BatiKa stores every upload on the "public" disk, and every view
         * reads it back through Storage::url(). In production this disk is
         * backed by Firebase Storage; locally it falls back to the normal
         * storage/app/public directory.
         */
        'public' => $publicDisk,

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
