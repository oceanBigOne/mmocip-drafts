<?php
namespace Site\Controller;
use JSend\JSendResponse as JSendResponse;
use Site\Service\RouteService;
use Site\Util\AjaxResponse;


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


        $ajaxResponse=new AjaxResponse();

        $validator = new \Sirius\Validation\Validator;

        // add a validation rule
        $validator->add('pseudo','required',null,__("Les champs suivi de * sont obligatoires"));
        $validator->add('pseudo','minlength',array('min' => 2),__("Le champs pseudo doit avoir au moins 2 caractères"));
        $validator->add('pseudo','maxlength',array('max' => 10),__("Le champs pseudo doit avoir moins de 10 caractères"));
        $bResult=$validator->validate($data);
        if ($bResult) {



            $ajaxResponse->setCallback("callbackTest",["param1","param2"],100);
            $ajaxResponse->setRedirect(RouteService::getPathOf("users"),["messageType"=>"success","message"=>__("Utilisateur sauvegardé correctement.")],1000);

            $response = new JSendResponse('success',$ajaxResponse->get());
        } else {
            $messages=$validator->getMessages();
            $message=reset($messages);
            $ajaxResponse->setMessage($message[0]->getTemplate(),"error");
            $response = new JSendResponse('fail',$ajaxResponse->get());

        }

        $response->respond();
        return [];
    }
}