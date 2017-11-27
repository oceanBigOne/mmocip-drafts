<?php
/**
 * Created by PhpStorm.
 * User: cleme
 * Date: 27/11/2017
 * Time: 19:22
 */

namespace Site;


class Entity
{
    public function hydrate($datas){
        foreach($datas as $key=>$value){
            $method=$this->field2MethodName($key);
            if(method_exists($this,$method)){
                $this->$method($value);
            }
        }

    }

    private function field2MethodName(string $fieldname,string $set_or_get="set"): string
    {
        $words = explode("_", $fieldname);
        $methodName = "";
        foreach ($words as $word) {
            if ($word) {
                $methodName .= ucfirst($word);
            }
        }
        return $set_or_get.ucfirst($methodName);
    }



    private function methodName2Field(string $methodName): string
    {
        $methodName=substr($methodName,3);
        $words = preg_split('/(?=[A-Z])/', $methodName, -1, PREG_SPLIT_NO_EMPTY);
        $fieldname = "";
        foreach ($words as $word) {
            if ($word) {
                $fieldname .= "_" . strtolower($word);
            }
        }
        if ($fieldname == "") {
            $fieldname = strtolower($methodName);
        }
        return substr($fieldname, 1);
    }
}