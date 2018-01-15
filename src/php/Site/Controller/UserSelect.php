<?php
namespace Site\Controller;
use JSend\JSendResponse as JSendResponse;
use Site\Service\RouteService;
use Site\Service\SessionService;
use Site\Util\AjaxResponse;
use Site\Model\User as UserModel;


/**
 * Class Users
 *
 * Affichage de la page USERS du site
 *
 * @package Site\Controller
 */
Class UserSelect implements IController {

    /**
     * @param array $data donnée en provenance de l'URL
     * @return array données à transmettre au twig
     */
    public function run(array $data):array{


        $ajaxResponse=new AjaxResponse();


        $user=null;
        $users=UserModel::where('id', '=', $data["userselect"])->get()[0];

        if(count($users)) {
            $user=$users;
            $ajaxResponse->setMessage(__("Utilisateur %s sélectionné.",$user->pseudo),"success");
            $ajaxResponse->setCallback("cb__UpdateUserPseudo",[$user->pseudo,$user->id],1000);
            $response = new JSendResponse('success',$ajaxResponse->get());

        }else {
            $users=UserModel::where('id', '!=', 0)->whereNull('deleted_at')->get();
            shuffle($users);
            $user=$users[0];
            $ajaxResponse->setRedirect(RouteService::getPathOf("users"),["messageType"=>"error","message"=>__("L'utilisateur sélectionné n'exitse plus.")],1000);
            $response = new JSendResponse('fail', $ajaxResponse->get());
        }

        SessionService::set("user_id",$user->id);
        SessionService::set("user_pseudo",$user->pseudo);

        $response->respond();
        return [];
    }
}