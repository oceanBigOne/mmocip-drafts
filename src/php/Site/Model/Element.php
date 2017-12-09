<?php
/**
 * Created by PhpStorm.
 * User: cleme
 * Date: 09/12/2017
 * Time: 15:30
 */

namespace Site\Model;
use Illuminate\Database\Eloquent\Model as Model;


class Element extends Model{

    private $_debat=null;

    public function getDebat(bool $force=false):Debat
    {
        if($this->_debat==null || $force){
            $this->_debat=Debat::where('id', '=', $this->getAttribute("debat_id"))->get()[0];
        }

        return $this->_debat;
    }
}