<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

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

	URL::formatPathUsing(function (string $path) {
            $prefix = trim(
                (string) request()->header('X-Forwarded-Prefix', ''),
                '/'
            );

            if ($prefix === '') {
                return $path;
            }

            $prefixPath = '/' . $prefix;
            $normalizedPath = '/' . ltrim($path, '/');

            // Evitar duplicar el prefijo.
            if (
                $normalizedPath === $prefixPath ||
                str_starts_with($normalizedPath, $prefixPath . '/')
            ) {
                return $normalizedPath;
            }

            return $prefixPath .
                ($normalizedPath === '/' ? '/' : $normalizedPath);
        });

        Vite::createAssetPathsUsing(function (string $path, ?bool $secure) {
            $prefix = trim(
                (string) request()->header('X-Forwarded-Prefix', ''),
                '/'
            );

            $path = ltrim($path, '/');

            if ($prefix !== '' && ! str_starts_with($path, $prefix . '/')) {
                $path = $prefix . '/' . $path;
            }

            return asset($path, $secure);
        });
    }
}
