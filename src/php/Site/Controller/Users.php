<?php
namespace Site\Controller;
use Site\Model\User as UserModel;

/**
 * Class Users
 *
 * Affichage de la page USERS du site
 *
 * @package Site\Controller
 */
Class Users implements IController {

    /**
     * @param array $data donnée en provenance de l'URL
     * @return array données à transmettre au twig
     */
    public function run(array $data):array{
        $dataTemplate=[];
        $dataTemplate["users"]=UserModel::where('id', '!=', 0)->get();
        return $dataTemplate;
    }
}