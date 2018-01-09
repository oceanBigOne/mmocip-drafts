<?php
/**
 * Project : mmocip-drafts
 * File : NodeTrans.php
 */

namespace Site\Twig\Node;


class Node_Trans extends \Twig_Extensions_Node_Trans
{

    /**
     * @param bool $plural Return plural or singular function to use
     *
     * @return string
     */
    protected function getTransFunction($plural)
    {
        return $plural ? '__' : '__';
    }
}