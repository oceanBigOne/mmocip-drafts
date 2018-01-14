<?php
/**
 * Project : mmocip-drafts
 * File : Message.php
 */

namespace Site\Controller;


class Message implements IController {

    /**
     * @param array $data donnée en provenance de l'URL
     * @return array données à transmettre au twig
     */
    public function run(array $data):array{

        if(!isset($data["modal_ref"])){
            $data["modal_ref"]="system/no-message";
        }
        $dataTemplate=$data;
        return $dataTemplate;
    }
}