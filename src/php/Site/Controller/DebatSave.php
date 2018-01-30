<?php
namespace Site\Controller;
use JSend\JSendResponse as JSendResponse;
use Site\Service\Route;
use Site\Util\AjaxResponse;
use Site\Model\Debat as DebatModel;


/**
 * Class DebatSave
 *
 * Sauvegarde l'ajout, la modification ou la suppression d'un debat
 *
 * @package Site\Controller
 */
Class DebatSave extends AbstractController {


    public function run(array $data):array{


        $ajaxResponse=new AjaxResponse();

        $validator = new \Sirius\Validation\Validator;

        $debat=new DebatModel();

        // add a validation rule
        $validator->add('title','required',null,__("Les champs suivi de * sont obligatoires"));
        $validator->add('title','minlength',array('min' => 2),__("Le champs titre doit avoir au moins 2 caractères"));
        $validator->add('title','maxlength',array('max' => 250),__("Le champs titre doit avoir moins de 250 caractères"));

        $bResult=$validator->validate($data);
        if ($bResult) {

            if(isset($data["id"]) && $data["id"]!=0){
                $debat=DebatModel::where('id', '=', $data["id"])->get()[0];
            }

            $debat->title=$data["title"];
            if(isset($data["delete"]) && $data["delete"]=="true"){
                $debat->deleted_at=strtotime("now");
                $ajaxResponse->setRedirectWithMessage(Route::getPathOf("Debats"),__("Débat supprimé correctement."),"success",[],1000);
            }else{
                $ajaxResponse->setRedirectWithMessage(Route::getPathOf("Debats"),__("Débat sauvegardé correctement."),"success",[],1000);
            }
            $debat->save();
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

    public function checkUri(array $data):bool{
        return true;
    }
}