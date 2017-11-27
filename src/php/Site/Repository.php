<?php
/**
 * Created by PhpStorm.
 * User: cleme
 * Date: 26/11/2017
 * Time: 19:53
 */

namespace Site;


class Repository
{


    public function getArrayOfObjects($results,$entityName){
        $return=[];
        foreach($results as $data){
            $obj = new $entityName;
            $obj->hydrate($data);
            array_push($return,$obj);
        }
        return $return;
    }



}