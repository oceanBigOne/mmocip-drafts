<?php
namespace Site\Controller;
use Site\Model\Debat as DebatModel;

/**
 * Class Home
 *
 * Affichage de la page HOME du site
 *
 * @package Site\Controller
 */
Class Home implements IController {

    /**
     * @param array $data donnée en provenance de l'URL
     * @return array données à transmettre au twig
     */
    public function run(array $data):array{
        $dataTemplate=[];
        return $dataTemplate;
    }
}