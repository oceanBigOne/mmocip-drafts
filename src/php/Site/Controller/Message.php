<?php
/**
 * Project : mmocip-drafts
 * File : Message.php
 */

namespace Site\Controller;

/**
 * Class Message
 *
 * Affiche un message sélectionné (paramètre POST modal_ref)
 *
 * @package Site\Controller
 */
class Message extends AbstractController {

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