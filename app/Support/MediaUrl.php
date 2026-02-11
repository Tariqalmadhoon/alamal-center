<?php

namespace App\Support;

use Illuminate\Support\Facades\Route;

class MediaUrl
{
    public static function for(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        $normalizedPath = str_replace('\\', '/', trim($path));
        $normalizedPath = preg_replace('#^/?storage/#', '', $normalizedPath);
        $normalizedPath = ltrim($normalizedPath, '/');

        if ($normalizedPath === '') {
            return null;
        }

        if (is_file(public_path('storage/'.$normalizedPath))) {
            return asset('storage/'.$normalizedPath);
        }

        if (Route::has('media.show')) {
            return route('media.show', ['path' => $normalizedPath]);
        }

        return asset('storage/'.$normalizedPath);
    }
}
