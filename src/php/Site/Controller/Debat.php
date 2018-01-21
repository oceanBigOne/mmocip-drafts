<?php
/**
 * Project : mmocip-drafts
 * File : Debat.php
 */

namespace Site\Controller;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Site\Model\Debat as DebatModel;
use Site\Model\Element as ElementModel;

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
        $dataTemplate["debat"]=DebatModel::where('id', '=', $data["id"])->get()[0];
        return $dataTemplate;
    }
}