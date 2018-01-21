<?php
/**
 * KzamBackend
 *
 * @author Studio K-ZAM <contact@k-zam.com>
 */
namespace Site\Controller;
use Site\Service\Route as Route;

/**
 * Interface IController
 *
 * Interface de déclaration des Controller
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
     * @param array $data donnée en provenance de l'URL
     * @return array données à transmettre au twig
     */
    abstract protected function run(array $data):array;

    public function getUri():string{
        return $this->uri;
    }

    public function setUri(string $uri):void{
        $this->uri=$uri;
    }

    /**
     * @param array $dataCorrect Données corrigé pour la génération de la route d'origine
     */
    public function generateOriginalUri(array $dataCorrect):void{
      $this->setUri(Route::getPathOf(get_class($this),$dataCorrect,strtolower($_SERVER['REQUEST_METHOD'])));
    }

}