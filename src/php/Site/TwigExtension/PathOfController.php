<?php
/**
 * Project : mmocip-drafts
 * File : PathOfController.php
 */
namespace Site\TwigExtension;

use Site\App;

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
        $app=new App();
        return $app->getPathOf($controller,$param);
    }

    public function getName()
    {
        return 'get_path_of';
    }

}