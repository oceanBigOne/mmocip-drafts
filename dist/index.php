<?php
session_start();

require '../vendor/autoload.php';
require '../config.php';
require '../routing.php';



use Site\Service\Config;
use Site\Service\Route;
use Site\Service\Session;

//initilisation de l'APP
$app=new \Site\App();

//parsage de la route
$app->parseRoute(Route::get());

//detection locale
$vars = $app->getRouteInfo();
if(isset($vars[2]) && isset($vars[2]["locale"]) ) {
    $locale=$vars[2]["locale"];
    Session::set("current-locale", $locale);
    require 'locale-detect.php';
    //run
    $app->run(Config::get("bdd"), Session::get("current-locale"), Config::get("default-locale"));
}else{
    header("HTTP/1.0 404 Not Found");
}

