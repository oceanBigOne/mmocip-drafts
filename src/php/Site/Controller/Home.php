<?php
namespace Site\Controller;


/**
 * Class Home
 *
 * Affichage de la page HOME du site
 *
 * @package Site\Controller
 */
Class Home extends AbstractController {


    public function run(array $data):array{
        $dataTemplate=[];

        return $dataTemplate;
    }

    public function checkUri(array $data):bool{
        return true;
    }
}