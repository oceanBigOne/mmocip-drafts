<?php
namespace Site\Controller;
use JSend\JSendResponse as JSendResponse;
use Site\Service\Route;
use Site\Util\AjaxResponse;
use Site\Model\User as UserModel;


/**
 * Class Users
 *
 * Sauvegarde l'ajout, la modification ou la suppression d'un user
 *
 * @package Site\Controller
 */
Class UserSave extends AbstractController {

    /**
     * @param array $data donnée en provenance de l'URL
     * @return array données à transmettre au twig
     */
    public function run(array $data):array{


        $ajaxResponse=new AjaxResponse();

        $validator = new \Sirius\Validation\Validator;

        $user=new UserModel();

        // add a validation rule
        $validator->add('pseudo','required',null,__("Les champs suivi de * sont obligatoires"));
        $validator->add('pseudo','minlength',array('min' => 2),__("Le champs pseudo doit avoir au moins 2 caractères"));
        $validator->add('pseudo','maxlength',array('max' => 20),__("Le champs pseudo doit avoir moins de 10 caractères"));

        $bResult=$validator->validate($data);
        if ($bResult) {

            if(isset($data["id"]) && $data["id"]!=0){
                $user=UserModel::where('id', '=', $data["id"])->get()[0];
            }

            $user->pseudo=$data["pseudo"];
            if(isset($data["delete"]) && $data["delete"]=="true"){
                $user->deleted_at=strtotime("now");
                $ajaxResponse->setRedirectWithMessage(Route::getPathOf("Users"),__("Utilisateur supprimé correctement."),"success",[],1000);
            }else{
                $ajaxResponse->setRedirectWithMessage(Route::getPathOf("Users"),__("Utilisateur sauvegardé correctement."),"success",[],1000);
            }
            $user->save();
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