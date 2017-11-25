<?php
/**
 * KzamBackend
 *
 * @author Studio K-ZAM <contact@k-zam.com>
 */
namespace Site\Controller;

/**
 * Interface IController
 *
 * Interface de déclaration des Controller
 *
 * @package Site\Controller
 */
Interface IController
{
    /**
     * @param array $data donnée en provenance de l'URL
     * @return array données à transmettre au twig
     */
    public function run(array $data):array;
}