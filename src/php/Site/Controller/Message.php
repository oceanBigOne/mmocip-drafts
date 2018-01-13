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
        $dataTemplate=$data;
        if(!isset($data["messageRef"])){
            $data["messageRef"]="system/no-message";
        }
        $dataTemplate["messageRef"]= $data["messageRef"];
        $dataTemplate["idModal"]= str_replace("/","-",$data["messageRef"]);

        return $dataTemplate;
    }
}