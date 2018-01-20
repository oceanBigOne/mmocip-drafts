<?php
/**
 * Project : mmocip-drafts
 * File : Route.phpamespace Site\Service;*/

namespace Site\Service;

use Site\App;

class Route
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
        $app->parseRoute(Route::get());
        if(!isset($param["locale"])){
            $param["locale"]=Session::get("current-locale");
        }
        return $app->getPathOf($controller,$param);


    }



}