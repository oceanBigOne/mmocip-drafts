<?php
/**
 * Project : mmocip-drafts
 * File : PathOfController.php
 */
namespace Site\Twig\Extension;

use Site\App;
use Site\Service\SessionService;
use Site\Service\RouteService;

class PathOfController extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('get_path_of', array($this, 'getPathOf')),
        );
    }


    public function getPathOf($controller,$param=[])
    {
        return RouteService::getPathOf($controller,$param);

    }

    public function getName()
    {
        return 'get_path_of';
    }

}