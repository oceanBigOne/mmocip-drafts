<?php
/**
 * Project : mmocip-drafts
*/

namespace Site\Service;

use Site\App;

/**
 * Class Route
 *
 * Service d'accès aux routes du site
 *
 * @package Site\Service
 */
class Route
{
    /**
     *  @return mixed
     */
    public static function get()
    {
        global $ROUTES;

        return $ROUTES;
    }

    /**
     *  @return mixed
     */
    public static function getPathOf(string $controller,array $param=[]):string
    {

        $app=new App();
        $app->parseRoute(Route::get());
        if(!isset($param["locale"])){
            $param["locale"]=Session::get("current-locale");
        }
        return $app->getPathOf($controller,$param);


    }


    /**
     * Traduction du nom de dossier en nom de classe
     *
     * renvoi un nom de dossier sous forme de nom de classes controller
     * le caractère - délimite les mots dans le nom de dossier
     * les majuscules délimitent les mots dans les noms des classes Controller
     *
     * @param string $dir nom du dossier
     * @return string nom de la class
     */
    public static function dir2Class(string $dir): string
    {
        $words = explode("-", $dir);
        $classname = "";
        foreach ($words as $word) {
            if ($word) {
                $classname .= ucfirst($word);
            }
        }
        return $classname;
    }


    /**
     * Traduction du nom de class en nom de dossier
     *
     * renvoi un nom de classe controller sous forme de nom de dossier
     * le caractère - délimite les mots dans le nom de dossier
     * les majuscules délimitent les mots dans les noms des classes Controller
     *
     * @param string $classname nom de la class
     * @return string nom de dossier
     */
    public static function class2Dir(string $classname): string
    {
        $words = preg_split('/(?=[A-Z])/', $classname, -1, PREG_SPLIT_NO_EMPTY);
        $dir = "";
        foreach ($words as $word) {
            if ($word) {
                $dir .= "-" . strtolower($word);
            }
        }
        if ($dir == "") {
            $dir = strtolower($classname);
        }
        return substr($dir, 1);
    }


    /**
     * Renvoi une chaine de caractère compatible avec une URL
     * @param $str string|null
     * @return string
     */
    public static function toPath(string $str= NULL):string{
        $clean="";
        if(!is_null($str)){
            $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
            $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
            $clean = strtolower(trim($clean, '-'));
            $clean = str_replace(" ","-",$clean);
        }
        return $clean;
    }



}