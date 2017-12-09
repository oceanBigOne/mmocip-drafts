<?php


namespace Site\TwigFilter;

use Site\App;

class FormatString extends \Twig_Extension
{
    /**
     * Renvoi une chaine de caractère compatible avec une URL
     * @param string $string
     * @return string
     */
    public static function toPath(string $str):string{

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = str_replace(" ","-",$clean);

        return $clean;
    }

    /**
     * Renvoi l'url d'un controlleur
     * @param string $controller
     * @param string $lang
     * @param array $param
     * @return string
     */
    public static function pathOf(string $controller,string $lang,array $param=[]):string{
        $app=new App();


        return $controller;
    }
}