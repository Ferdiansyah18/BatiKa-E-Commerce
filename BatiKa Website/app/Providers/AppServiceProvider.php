<?php

namespace App\Providers;

use App\Support\FirebaseFilesystemAdapter;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter;
use League\Flysystem\GoogleCloudStorage\UniformBucketLevelAccessVisibility;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        $this->registerFirebaseStorageDriver();
    }

    /**
     * Register the "firebase" filesystem driver.
     *
     * Firebase Storage is backed by a Google Cloud Storage bucket, so we can
     * reuse the official Flysystem adapter. The bucket is expected to use
     * uniform bucket-level access (the default for new Firebase projects),
     * hence the UniformBucketLevelAccessVisibility handler.
     */
    protected function registerFirebaseStorageDriver(): void
    {
        Storage::extend('firebase', function ($app, array $config) {
            $client = new StorageClient([
                'projectId' => $config['project_id'] ?? null,
                'keyFile' => $config['credentials'] ?? null,
            ]);

            $adapter = new GoogleCloudStorageAdapter(
                $client->bucket($config['bucket']),
                $config['path_prefix'] ?? '',
                new UniformBucketLevelAccessVisibility()
            );

            return new FirebaseFilesystemAdapter(
                new Flysystem($adapter),
                $adapter,
                $config
            );
        });
    }
}
