<?php
/**
 * Project : mmocip-drafts
 * File : AllMessages.php
 */

namespace Site\Controller;


class AllMessages implements IController {

    /**
     * @param array $data donnée en provenance de l'URL
     * @return array données à transmettre au twig
     */
    public function run(array $data):array{

        $sPath="../src/template/fr_FR/message";

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