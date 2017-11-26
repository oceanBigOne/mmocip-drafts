<?php
/**
 * Created by PhpStorm.
 * User: cleme
 * Date: 26/11/2017
 * Time: 19:27
 */

namespace Site\Repository;
use Illuminate\Database\Capsule\Manager as Capsule;
use Site\Entity\Debat as Debat;
use Site\Repository;

class DebatRepository extends Repository
{
    public function findAll(){

        $results = Capsule::select('select * from debat ');

        return $this->getArrayOfObjects($results,"Site\Entity\Debat");
    }

    public function find($id){
        $return=[];
        $results = Capsule::select('select * from debat where id=? ',[$id]);
        return $return;
    }
}