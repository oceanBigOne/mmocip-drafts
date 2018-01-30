<?php
namespace Site\Controller;
use JSend\JSendResponse as JSendResponse;
use Site\Service\Route;
use Site\Service\Session;
use Site\Util\AjaxResponse;
use Site\Model\User as UserModel;


/**
 * Class Users
 *
 * Sélectionne un user pour qu'il devienne l'utilisateur courant
 *
 * @package Site\Controller
 */
Class UserSelect extends AbstractController {


    public function run(array $data):array{

        $ajaxResponse=new AjaxResponse();

        $user=null;

        $users=UserModel::where('id', '=', $data["userselect"])->get()[0];

        if(!is_null($users)) {
            $user=$users;
            $ajaxResponse->setMessage(__("Utilisateur %s sélectionné.",$user->pseudo),"success");
            $ajaxResponse->setCallback("cb__UpdateUserPseudo",[$user->pseudo,$user->id],1000);
            $response = new JSendResponse('success',$ajaxResponse->get());

        }else {
            $users=UserModel::where('id', '!=', 0)->whereNull('deleted_at')->get();
            shuffle($users);
            $user=$users[0];
            $ajaxResponse->setRedirect(Route::getPathOf("Users"),["messageType"=>"error","message"=>__("L'utilisateur sélectionné n'exitse plus.")],1000);
            $response = new JSendResponse('fail', $ajaxResponse->get());
        }

        Session::set("user_id",$user->id);
        Session::set("user_pseudo",$user->pseudo);

        $response->respond();
        return [];
    }

    public function checkUri(array $data):bool{
        return true;
    }
}