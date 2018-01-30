<?php
/**
 * KzamBackend
 *
 * @author Studio K-ZAM <contact@k-zam.com>
 */
namespace Site\Controller;
use Site\Service\Route as Route;

/**
 * Class AbstractController
 *
 * Classe abstraite pour la génération des controlleurs
 *
 * @package Site\Controller
 */
Abstract class AbstractController
{

    /**
     * Adresse de la page exacte (pour faire une redirection 301 si besoin)
     * @var null
     */
    private $uri="";

    /**
     * Fonction permettant d'obtenir toutes les données à renvoyer au TWIG
     * @param array $data donnée en provenance de l'URL
     * @return array données à transmettre au twig
     */
    abstract protected function run(array $data):array;


    /**
     * Fonction permettant de tester si l'URI généré correspond exactement à l'URI appelé (pour faire éventuellement une redirection 301)
     * @param array $data donnée en provenance de l'URL
     * @return bool
     */
    abstract protected function checkUri(array $data):bool;

     /**
     * @return string
     */
    public function getUri():string{
        return $this->uri;
    }

    /**
     * @param string $uri
     */
    public function setUri(string $uri):void{
        $this->uri=$uri;
    }

    /**
     * Génére l'URI correcte de la page en cours
     * @param array $dataCorrect Données corrigé pour la génération de la route d'origine
     */
    public function generateOriginalUri(array $dataCorrect):void{
      $this->setUri(Route::getPathOf(get_class($this),$dataCorrect,strtolower($_SERVER['REQUEST_METHOD'])));
    }

}