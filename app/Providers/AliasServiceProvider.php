<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class AliasServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
      // Get the AliasLoader instance
      $loader = AliasLoader::getInstance();

      // Add your aliases
      $loader->alias('Helper', \App\Helpers\Helper::class);
      $loader->alias('Image', Intervention\Image\Facades\Image::class);
      $loader->alias('Excel', Maatwebsite\Excel\Facades\Excel::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
