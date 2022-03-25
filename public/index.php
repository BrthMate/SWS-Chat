<?php

use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;

require_once __DIR__.'/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$dbConfig= [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password'=> $_ENV['DB_PASSWORD'],
    ]
];

$app = new Application( dirname(__DIR__) ,$dbConfig);

$app->Router->get('/',[AuthController::class,"index"]);
$app->Router->post('/',[AuthController::class,"index"]);
$app->Router->get('/regist',[AuthController::class,"regist"]);
$app->Router->post('/regist',[AuthController::class,"regist"]);
$app->Router->get('/forget',[AuthController::class,"forget"]);
$app->Router->post('/forget',[AuthController::class,"forget"]);
$app->Router->get('/logout',[AuthController::class,"logout"]);

$app->Router->get('/message',[SiteController::class,"message"]);
$app->Router->post('/message',[SiteController::class,"message"]);

//ajax
$app->Router->get('/message-ajax-search',[SiteController::class,"search"]);
$app->Router->get('/message-ajax-default',[SiteController::class,"contact"]);
$app->Router->get('/message-ajax-unread',[SiteController::class,"unread"]);
$app->Router->get('/message-ajax-chat',[SiteController::class,"chat"]);
$app->Router->get('/message-ajax-chatuser',[SiteController::class,"userdetails"]);
$app->Router->post('/message-ajax-sendmessage',[SiteController::class,"sendmessage"]);
$app->run();