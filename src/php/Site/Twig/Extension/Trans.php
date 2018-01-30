<?php
/**
 * Project : mmocip-drafts
 * File : PathOfController.php
 */
namespace Site\Twig\Extension;



class Trans extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('trans', array($this, 'trans')),
        );
    }


    public function trans($str)
    {
        return __($str);

    }

    public function getName()
    {
        return 'trans';
    }

}