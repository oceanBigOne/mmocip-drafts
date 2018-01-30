<?php
namespace Site\Controller;
use Site\Model\User as UserModel;
use Site\Service\Route;

/**
 * Class Users
 *
 * Affiche le formulaire d'édition d'un user
 *
 * @package Site\Controller
 */
Class User extends AbstractController {


    public function run(array $data):array{
        $dataTemplate=[];

        if($data["id"]!=0){
            $dataTemplate["user"]=UserModel::where('id', '=', $data["id"])->get()[0];

        }else{
            $dataTemplate["user"]=new UserModel();

        }

        return $dataTemplate;
    }

    public function checkUri(array $data):bool{
        $user=null;
        $dataCorrect=$data;

        if($data["id"]!=0){
            $user=UserModel::where('id', '=', $data["id"])->get()[0];
            $dataCorrect["name"]= Route::str2Uri($user->pseudo);
        }else{
            $dataCorrect["name"]= Route::str2Uri(__("Ajouter"));
        }

        //generation de l'URI corrigé pour 301
        $this->generateOriginalUri($dataCorrect);

        return ($_SERVER["REQUEST_URI"]==$this->getUri());
    }
}