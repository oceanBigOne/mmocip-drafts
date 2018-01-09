<?php
/**
 * Project : mmocip-drafts
 * File : RouteService.php
 */

namespace Site\Service;


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
}