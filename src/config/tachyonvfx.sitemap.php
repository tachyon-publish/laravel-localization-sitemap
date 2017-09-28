<?php


return [

    /*Exclude routes from sitemap*/
    'exclude' => [
        "",
        "cookies",
        "sitemap",
        "legality",
        "privacy",
        "login",
        "logout",
        "register",
        "filemanager",
        "home"
    ],

    'partials' => [
        "orders.",
        "password.",
        "admin.",
        "unisharp.",
        "filemanager."
    ],

    /* Following routes are not localized!*/
    'notLocalized' => [
        'auth.email.verify',
        'auth.passwords.resendVerification'
    ],

    /**/
    'routesLocalizationPath' => 'routes/web',

    /**
     * I'm sure you need to map route names to strings.
     * Route::(LaravelLocalization::transRoute('contact-us'), function(){})->name('contact');
     * 'contact' => 'contact-us'
     * Route name => Localization String
    **/
    'map' => [
        'page' => 'pages',
        'post' => 'posts',
        'tag' => 'tags',
        'backend.dashboard' => 'backend', //always first to avoid replacement
        'backend.' => 'resources.'
    ],

    'mapExclude' => [

    ]
];
