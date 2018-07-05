<?php

global $project;
$project = 'mainsite';

global $database;
$database = SS_DATABASE_NAME;

if (Director::isLive() && Config::inst()->get('WWWSSL', 'Enforced')) {

    Director::forceSSL();

    $ignores =   Config::inst()->get('WWWSSL', 'IgnoreOrigins');

    if (!in_array($_SERVER['HTTP_HOST'], $ignores)) {
        Director::forceWWW();
    }
}

Email::mailer()->setMessageEncoding('base64');

// Use _ss_environment.php file for configuration
require_once("conf/ConfigureFromEnv.php");

if (extension_loaded('imagick')) {
    ImagickBackend::set_default_quality(90);
    Image::set_backend("ImagickBackend");
} else {
    GD::set_default_quality(90);
    Image::set_backend("OptimisedGDBackend");
}

SS_Cache::set_cache_lifetime('PageDataCache', 31536000);

Requirements::set_write_js_to_body(false);

if (Director::isLive()) {
    SS_Log::add_writer(new SS_LogEmailWriter('leochenftw@gmail.com'), SS_Log::ERR);
}

if(class_exists('Memcache')) {
    SS_Cache::add_backend(
        'primary_memcached',
        'Memcached',
        array(
            'host' => 'localhost',
            'port' => 11211,
            'persistent' => true,
            'weight' => 1,
            'timeout' => 1,
            'retry_interval' => 15,
            'status' => true,
            'failure_callback' => ''
        )
    );
    SS_Cache::pick_backend('primary_memcached', 'any', 10);
}

i18n::set_locale('en_NZ');
Translatable::set_default_locale('en_NZ');
Translatable::set_allowed_locales([
    'zh_Hans',
    'en_NZ'
]);

Object::add_extension('SiteTree', 'Translatable');
Object::add_extension('SiteConfig', 'Translatable');
