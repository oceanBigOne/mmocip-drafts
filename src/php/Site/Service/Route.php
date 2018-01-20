<?php
/**
 * Project : mmocip-drafts
*/

namespace Site\Service;

use Site\App;

/**
 * Class Route
 *
 * Service d'accès aux routes du site
 *
 * @package Site\Service
 */
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