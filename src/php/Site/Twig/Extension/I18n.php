<?php
/**
 * Project : mmocip-drafts
 * File : I18n.php
 */

namespace Site\Twig\Extension;



class I18n extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getTokenParsers()
    {
        return array(new \Site\Twig\TokenParser\TokenParser_Trans());
    }
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {

        return array(

           new \Twig_SimpleFilter('trans',"__")
        );
    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'i18n';
    }

}