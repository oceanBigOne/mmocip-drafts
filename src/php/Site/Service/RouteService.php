<?php
/**
 * Project : mmocip-drafts
 * File : RouteService.php
 */

namespace Site\Service;


use Site\App;

class RouteService
{
    /**
     *  @return mixed
     */
    public static function get()
    {
        global $ROUTES;

        return $ROUTES;
    }

    /**
     *  @return mixed
     */
    public static function getPathOf(string $controller,array $param=[]):string
    {

        $app=new App();
        $app->parseRoute(RouteService::get());
        if(!isset($param["locale"])){
            $param["locale"]=SessionService::get("current-locale");
        }
        return $app->getPathOf($controller,$param);


    }



}