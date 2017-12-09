<?php
namespace Site\Controller;
use Site\Model\Debat as DebatModel;

/**
 * Class Debats
 * @package Site\Controller
 */
Class Debats implements IController {

    /**
     * @param array $data donnée en provenance de l'URL
     * @return array données à transmettre au twig
     */
    public function run(array $data):array{
        $dataTemplate=[];
        $dataTemplate["debats"]=DebatModel::where('id', '!=', 0)->get();
        return $dataTemplate;
    }
}