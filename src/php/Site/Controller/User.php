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

    /**
     * @param array $data donnée en provenance de l'URL
     * @return array données à transmettre au twig
     */
    public function run(array $data):array{
        $dataTemplate=[];
        $dataCorrect=$data;

        if($data["id"]!=0){
            $dataTemplate["user"]=UserModel::where('id', '=', $data["id"])->get()[0];
            $dataCorrect["name"]= Route::toPath($dataTemplate["user"]->pseudo);
        }else{
            $dataTemplate["user"]=new UserModel();
            $dataCorrect["name"]= Route::toPath(__("Ajouter"));
        }

        //generation de l'URI corrigé pour 301
        $this->generateOriginalUri($dataCorrect);

        return $dataTemplate;
    }
}