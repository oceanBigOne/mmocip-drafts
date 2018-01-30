<?php


namespace Site\Twig\Filter;

use Site\App;
use Site\Service\Route;

class FormatString extends \Twig_Extension
{
    /**
     * Renvoi une chaine de caractère compatible avec une URL
     * @param string $str
     * @return string
     */
    public static function toPath(string $str=NULL):string{

       return Route::toPath($str);
    }



}