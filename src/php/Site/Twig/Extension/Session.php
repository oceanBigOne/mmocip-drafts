<?php
/**
 * Project : mmocip-drafts
 * File : Session.php
 */

namespace Site\Twig\Extension;


use Site\Service\Session as  SessionService;

class Session extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('session', array($this, 'session')),
        );
    }


    public function session($string)
    {
        return SessionService::get($string);

    }

    public function getName()
    {
        return 'session';
    }

}