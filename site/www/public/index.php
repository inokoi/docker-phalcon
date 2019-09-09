<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use Phalcon\Mvc\Micro;

$app = new Micro();

$app['view'] = function () {
    $view = new \Phalcon\Mvc\View\Simple();
    $view->setViewsDir('app/views/');
    return $view;
};

$app->get(
    '/',
    function () use ($app) {
        echo $app['view']->render(
            'home'
        );
    }
);

$app->handle();