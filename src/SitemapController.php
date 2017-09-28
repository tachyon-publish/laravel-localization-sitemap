<?php

namespace Tachyonvfx\Localization\Sitemap;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Tachyonvfx\Localization\Sitemap\Repositories\SitemapRepository;

class SitemapController extends Controller
{
    protected $sitemapRepo;

    public function __construct(SitemapRepository $sitemapRepo)
    {
          $this->sitemapRepo = $sitemapRepo;
    }

    public function index(Request $request)
    {
        $excludedRoutes = config('tachyonvfx.sitemap.explude');

        $excludedPartials = config('tachyonvfx.sitemap.partials');

        //dd( config('tachyonvfx.sitemap.exclude') );
        $nonLocalized = config('tachyonvfx.sitemap.notLocalized');
        foreach ($nonLocalized as $value) {
            $excludedRoutes[] = $value;
        }
        //$routes = $this->sitemapRepo->getStaticRoutes($excludedRoutes, $excludedPartials, 1.0);

        /* Here you can add custom parsers in case you want to generate
         * routes for posts, products, profiles, etc. i.e. here is a custom
         * method that should return the routes of all the posts in your web.
         */

        // $postsRoutes = $this->getPostRoutes('posts.show', 0.9);

        //$routes = array_merge($routes, $postsRoutes);

        $routes = $this->sitemapRepo->getAllRoutes($excludedRoutes,  $excludedPartials, 1.0);

        //dd($routes);

        $data = compact('routes');

        return response()
            ->view('tachyonvfx.sitemap::xml', $data)
            ->header('Content-Type', 'text/xml');
    }
}
