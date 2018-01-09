<?php

require '../vendor/autoload.php';
require '../config.php';
require '../routing.php';



use Site\Service\ConfigService;
use Site\Service\RouteService;
use Site\Service\SessionService;

//initilisation de l'APP
$app=new \Site\App();

//parsage de la route
$app->parseRoute(RouteService::get());

//detection locale
$locale = $app->getRouteInfo()[2]["locale"];
SessionService::set("current-locale",$locale);
require 'locale-detect.php';
//run
$app->run(ConfigService::get("bdd"),SessionService::get("current-locale"),ConfigService::get("default-locale"));

