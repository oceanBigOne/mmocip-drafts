<?php
/**
 * Project : mmocip-drafts
 * File : Test.php
 */

namespace Site\Controller\Test;
use Site\Controller\AbstractController;

class Test extends AbstractController {


    public function run(array $data):array{
        $dataTemplate=[];

        return $dataTemplate;
    }

    public function checkUri(array $data):bool{
        return true;
    }
}