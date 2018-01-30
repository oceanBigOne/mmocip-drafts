<?php
namespace Site\Controller;
use Site\Model\Debat as DebatModel;

/**
 * Class Debats
 *
 * Affiche la page avec la liste des débats
 *
 * @package Site\Controller
 */
Class Debats extends AbstractController {


    public function run(array $data):array{
        $dataTemplate=[];
        $dataTemplate["debats"]=DebatModel::where('id', '!=', 0)->get();
        return $dataTemplate;
    }

    public function checkUri(array $data):bool{
        return true;
    }
}