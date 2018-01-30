<?php
/**
 * Project : mmocip-drafts
 * File : Debat.php
 */

namespace Site\Controller;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Site\Model\Debat as DebatModel;
use Site\Model\Element as ElementModel;
use Site\Service\Route;

/**
 * Class Debat
 *
 * Affiche la page de débat
 *
 * @package Site\Controller
 */
class Debat extends AbstractController {

    /**
     * @param array $data donnée en provenance de l'URL
     * @return array données à transmettre au twig
     */
    public function run(array $data):array{
        $dataTemplate=[];
        //$dataCorrect=$data;

        if($data["id"]!=0){
            $dataTemplate["debat"]=DebatModel::where('id', '=', $data["id"])->get()[0];
            //$dataCorrect["name"]= Route::str2Uri($dataTemplate["debat"]->pseudo);
        }else{
            $dataTemplate["debat"]=new DebatModel();
            //$dataCorrect["name"]= Route::str2Uri(__("Ajouter"));
        }

        //generation de l'URI corrigé pour 301
       // $this->generateOriginalUri($dataCorrect);

        return $dataTemplate;
    }

    public function checkUri(array $data):bool{
        return true;
    }
}