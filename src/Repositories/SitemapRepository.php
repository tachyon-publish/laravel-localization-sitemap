<?php

namespace Tachyonvfx\Localization\Sitemap\Repositories;

use Route;
use LaravelLocalization;

class SitemapRepository
{

    public function getStaticRoutes($excludedRoutes = [], $excludedPartials = [], $priority = 1.0)
    {
        $routes = $this->getStaticRouteNames($excludedRoutes, $excludedPartials);
        $locales = LaravelLocalization::getSupportedLanguagesKeys();
        $staticRoutes = [];

        $exclude = config('tachyonvfx.sitemap.exclude');
        //dd($routes);

        foreach( $locales as $locale ){

            foreach ( $routes as $route){
                $r = [];

                //if($route != 'site') dd($this->getLocalizedURL( $locale, $route));

                if (!in_array($route, $exclude)) {
                    $loc = $this->getLocalizedURL( $locale, $route);
                    $r['loc'] = $loc ? $loc : "";
                    $r['priority'] = $priority;

                    foreach ($locales as $alternate) {
                        $alt = $this->getLocalizedURL( $alternate, $route);
                        $r['alternates'][$alternate] =  $alt ? $alt : "";
                    }
                    $staticRoutes[] = $r;
                }
            }
        }
        return $staticRoutes;
    }

    public function getStaticRouteNames($excludedRoutes = [], $excludedPartials = [])
    {
        $allRoutes = Route::getRoutes();

        $staticRouteNames = array();

        foreach ( $allRoutes as $route){

            if(in_array("GET", $route->methods))
            {
                if( ! in_array($route->getName(), $excludedRoutes )
                    && ! $this->strpos_array($route->getName(), $excludedPartials )
                    )
                {
                    $staticRouteNames [] = $route->getname();
                }
            }
        }
        return $staticRouteNames;
    }

    private function strpos_array($haystack, $needle, $offset=0)
    {
        if(!is_array($needle)) $needle = array($needle);

        foreach($needle as $query) {
            if(strpos($haystack, $query, $offset) !== false) return true; // stop on first true result
        }

        return false;
    }

    public function getLocalizedURL($locale, $baseRouteName, $args = [])
    {
        $routesPath = config('tachyonvfx.sitemap.routesLocalizationPath').'.';
        return LaravelLocalization::getURLFromRouteNameTranslated( $locale, $routesPath.$baseRouteName, $args);
    }

    public function getSupportedLocalesKeys()
    {
        return LaravelLocalization::getSupportedLanguagesKeys();
    }








    public function getAllRoutes($excludedRoutes, $excludedPartials, $priority)
    {
        $exclude = config('tachyonvfx.sitemap.exclude');
        $excludedRoutes = array_merge($excludedRoutes, $exclude);

        $routesLocalizationPath = config('tachyonvfx.sitemap.routesLocalizationPath');
        $map = config('tachyonvfx.sitemap.map');
        $mapExclude = config('tachyonvfx.sitemap.mapExclude');

        //get all localization strings...
        $routeStrings = \Lang::get($routesLocalizationPath);

        $routes = $this->getStaticRouteNamesX($excludedRoutes, $excludedPartials);
        $locales = LaravelLocalization::getSupportedLanguagesKeys();
        $staticRoutes = [];

        foreach( $locales as $locale ){
            foreach ( $routes as $route){
                $r = [];
                if (!in_array($route, $exclude)) {
                    foreach ($map as $key => $value) {
                        if($route == $key) $route = $value;
                        //check if $route starts with $key.
                        if(!in_array($route, $mapExclude)){
                            if (strpos($route, $key) === 0) {
                                $route = str_replace($key,$value,$route);
                            }
                        }
                    }
                    $loc = $this->getLocalizedURL( $locale, $route);
                    $r['loc'] = $loc ? $loc : "";
                    $r['priority'] = $priority;

                    foreach ($locales as $alternate) {
                        $alt = $this->getLocalizedURL( $alternate, $route);
                        $r['alternates'][$alternate] =  $alt ? $alt : "";
                    }
                    $staticRoutes[] = $r;
                }
            }
        }
        return $staticRoutes;
    }


    public function getStaticRouteNamesX($excludedRoutes = [], $excludedPartials = [])
    {
        $allRoutes = Route::getRoutes();
        $staticRouteNames = array();
        foreach ( $allRoutes as $route){
            if(in_array("GET", $route->methods))
            {
                if( ! in_array($route->getName(), $excludedRoutes )
                    && ! $this->strpos_array($route->getName(), $excludedPartials )
                    )
                {
                    $staticRouteNames [] = $route->getname();
                }
            }
        }
        return $staticRouteNames;
    }


}
