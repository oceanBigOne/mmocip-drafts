<?php
/**
 * Project : mmocip-drafts
 * File : PathOfController.php
 */
namespace Site\Twig\Extension;

use Site\App;
use Site\Service\Session;
use Site\Service\Route;

class PathOfController extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getPathOf', array($this, 'getPathOf')),
        );
    }


    public function getPathOf($controller,$param=[],$method='get')
    {
        return Route::getPathOf($controller,$param,$method);

    }

    public function getName()
    {
        return 'getPathOf';
    }

}