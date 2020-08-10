<?php
require 'vendor/autoload.php';
use Framework\Router;


$router = new Router;
$router->routeRequest();



//class view ?
//create environment with default config
/*$loader = new \Twig\Loader\FilesystemLoader('View');
$twig = new \Twig\Environment($loader, [
    'cache' => FALSE/*'/path/to/compilation_cache',  //penser a remettre le cache
]);

$template = $twig->load('index.php');

echo $twig->render('home.php', ['titi' => 'roro']);*/