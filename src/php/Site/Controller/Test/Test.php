<?php
/**
 * Project : mmocip-drafts
 * File : Test.php
 */

namespace Site\Controller\Test;
use Site\Controller\AbstractController;

class Test extends AbstractController {

    /**
     * @param array $data donnée en provenance de l'URL
     * @return array données à transmettre au twig
     */
    public function run(array $data):array{
        $dataTemplate=[];

        return $dataTemplate;
    }
}