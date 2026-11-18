<?php

namespace App\Support;

use Illuminate\Filesystem\FilesystemAdapter;

/**
 * Laravel filesystem adapter for a Firebase Storage bucket.
 *
 * Laravel's default filesystem adapter can only generate public URLs for the
 * local, FTP and SFTP drivers. Because all BatiKa views rely on
 * Storage::url(), we extend the adapter so uploaded files resolve to the
 * public Firebase Storage download endpoint.
 */
class FirebaseFilesystemAdapter extends FilesystemAdapter
{
    /**
     * Get the public URL for a file stored in the Firebase Storage bucket.
     */
    public function url($path)
    {
        $bucket = $this->config['bucket'] ?? null;

        if (! $bucket) {
            return parent::url($path);
        }

        return sprintf(
            'https://firebasestorage.googleapis.com/v0/b/%s/o/%s?alt=media',
            rawurlencode($bucket),
            rawurlencode(ltrim($path, '/'))
        );
    }
}
