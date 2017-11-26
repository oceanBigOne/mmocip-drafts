<?php
/**
 * Created by PhpStorm.
 * User: cleme
 * Date: 26/11/2017
 * Time: 19:28
 */

namespace Site\Repository;
use Illuminate\Database\Capsule\Manager as Capsule;
use Site\Entity\Element as Element;
use Site\Repository;


class ElementRepository extends Repository
{
    public function findAll(){

        $results = Capsule::select('select * from element ');

        return $this->getArrayOfObjects($results,"Site\Entity\Element");
    }

    public function find($id){
        $return=[];
        $results = Capsule::select('select * from element where id=? ',[$id]);
        return $return;
    }
}