<?php

//Route::get('sitemap.xml', ['uses' => 'SitemapController@index', 'as' => 'sitemap']);


//localhost/lavoulp/public/sitemap.xml

Route::namespace('Tachyonvfx\Localization\Sitemap')->group(function () {
  Route::get('sitemap.xml', 'SitemapController@index');
});
