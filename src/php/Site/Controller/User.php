<?php
namespace Site\Controller;
use Site\Model\User as UserModel;

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

        if($data["id"]!=0){
            $dataTemplate["user"]=UserModel::where('id', '=', $data["id"])->get()[0];
        }else{
            $dataTemplate["user"]=new UserModel();
        }

        //generation de l'URI corrigé pour 301
        $dataCorrect=$data;
        $dataCorrect["name"]= $dataTemplate["user"]->pseudo;
        $this->generateOriginalUri($dataCorrect);

        return $dataTemplate;
    }
}