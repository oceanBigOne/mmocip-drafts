<?php
namespace Site\Controller;
use JSend\JSendResponse as JSendResponse;

/**
 * Class Users
 *
 * Affichage de la page USERS du site
 *
 * @package Site\Controller
 */
Class UserSave implements IController {

    /**
     * @param array $data donnée en provenance de l'URL
     * @return array données à transmettre au twig
     */
    public function run(array $data):array{
        $dataTemplate=[];
        $data=[];
        $success = new JSendResponse('success', $data);


        //$fail = new JSendResponse('fail', $data);
        //$error = new JSendResponse('error', $data, 'Not cool.', 9001);
        $dataTemplate["json"]=(string) $success;
        return $dataTemplate;
    }
}