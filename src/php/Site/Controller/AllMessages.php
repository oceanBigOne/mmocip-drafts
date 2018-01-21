<?php
/**
 * Project : mmocip-drafts
 * File : AllMessages.php
 */

namespace Site\Controller;

/**
 * Class AllMessages
 *
 * Affiche la page avec la liste de tous les messages (modal) affichés sur le site
 *
 * @package Site\Controller
 */
class AllMessages extends AbstractController {

    /**
     * @param array $data donnée en provenance de l'URL
     * @return array données à transmettre au twig
     */
    public function run(array $data):array{

        $sPath="../src/template/fr-fr/message";

        $dataTemplate["files"]=[];
        $directory = new \RecursiveDirectoryIterator($sPath);
        $iterator = new \RecursiveIteratorIterator($directory);
        $files = new \RegexIterator($iterator, '/^.+\.twig$/i', \RecursiveRegexIterator::GET_MATCH);

        foreach ($files as $file) {
            $dataTemplate["files"][]=str_replace("../src/template/","",$file[0]);
        }

        return $dataTemplate;
    }
}