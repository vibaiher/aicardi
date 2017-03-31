<?php

require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

# Register monolog
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/logs/aicardi.log',
));

# Register twig and 'assets' helper
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/views',
));
$app['twig'] = $app->extend('twig', function($twig, $app) {
    $twig->addFunction(new \Twig_SimpleFunction('asset', function($asset) {
        return sprintf('/assets/%s', ltrim($asset, '/'));
    }));

    return $twig;
});

$app->get('/', function() use($app) {
    return $app['twig']->render('index.html.twig');
});

$app->get('/conciertos', function() use($app) {
    return $app['twig']->render('concerts/index.html.twig');
});

$app->get('/sobre-nosotros', function() use($app) {
    return $app['twig']->render('about/about.html.twig');
});

$app->get('/strata', function() use($app) {
    return $app['twig']->render('strata.html.twig');
});

$app->run();
