<?php
namespace Site\Controller;
use Site\Model\User as UserModel;

/**
 * Class Users
 *
 * Affichage de la page USERS du site
 *
 * @package Site\Controller
 */
Class User implements IController {

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


        /*putenv('LC_ALL=fr_FR');
        setlocale(LC_ALL, 'fr_FR');

        $pathToDomain = substr(__DIR__,0,-20) .DIRECTORY_SEPARATOR."locales";
        if ($pathToDomain != bindtextdomain("mmocip-draft", $pathToDomain)) {

        }else {
        }

        textdomain("mmocip-draft");
        $dataTemplate["test"]=_("bonjour");*/

        return $dataTemplate;
    }
}