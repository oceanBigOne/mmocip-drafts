<?php
namespace Site\Controller;
use Site\Repository\DebatRepository as DebatRepository;

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

        $debatsList=new DebatRepository();
        $dataTemplate["debats"]=$debatsList->findAll();

        return $dataTemplate;
    }
}