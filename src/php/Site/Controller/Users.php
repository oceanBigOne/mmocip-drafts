<?php
namespace Site\Controller;
use Site\Model\User as UserModel;
use Site\Service\Session;

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

        if(isset($data["message"])){
            $dataTemplate["message"]=$data["message"];
        }
        if(isset($data["messageType"])){
            $dataTemplate["messageType"]=$data["messageType"];
        }

        $dataTemplate["users"]=UserModel::where('id', '!=', 0)->whereNull('deleted_at')->get();

        if(Session::get("user_id")==null){
            $rand=random_int(0,count($dataTemplate["users"])-1);
            $user=$dataTemplate["users"][$rand];
            Session::set("user_id",$user->id);
            Session::set("user_pseudo",$user->pseudo);
        }
        $dataTemplate["checked_user_id"]=Session::get("user_id");
        return $dataTemplate;
    }
}