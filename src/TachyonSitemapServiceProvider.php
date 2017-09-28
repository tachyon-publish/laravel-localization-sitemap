<?php

namespace Tachyonvfx\Localization\Sitemap;

use Illuminate\Support\ServiceProvider;

class TachyonSitemapServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
      include __DIR__.'/routes/sitemap.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/tachyonvfx.sitemap.php', 'tachyonvfx.sitemap');
        $this->app->make('Tachyonvfx\Localization\Sitemap\SitemapController');
        $this->loadViewsFrom(__DIR__.'/views', 'tachyonvfx.sitemap');
    }
}
