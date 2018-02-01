<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

// enable the debug mode
$app['debug'] = true;

//Chemin Twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    	'twig.path' => __DIR__.'/../views',
));

require __DIR__.'/../app/routes.php';
require __DIR__.'/../app/session.php';

$app->run();