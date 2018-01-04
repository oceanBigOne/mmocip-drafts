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

        $dataResponse=[];
        $validator = new \Sirius\Validation\Validator;

        // add a validation rule
        $validator->add('pseudo','required',null,"Les champs suivi de * sont obligatoires");
        $validator->add('login','required',null,"Les champs suivi de * sont obligatoires");

        if ($validator->validate($data)) {
            $dataResponse["message"]="Utilisateur sauvegardé";
            $response = new JSendResponse('success',$dataResponse);
        } else {
            $messages=$validator->getMessages();
            $dataResponse["message"]=reset($messages);
            $dataResponse=array_merge($dataResponse,$validator->getMessages());
            $response = new JSendResponse('fail',$dataResponse);

        }

        $response->respond();
        return [];
    }
}