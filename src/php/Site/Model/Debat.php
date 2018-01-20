<?php
/**
 * Created by PhpStorm.
 * User: cleme
 * Date: 09/12/2017
 * Time: 15:09
 */

namespace Site\Model;
use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Collection;

/**
 * Class Debat
 *
 * Objet débat
 *
 * @package Site\Model
 */
class Debat extends Model{

    private $_elements=null;



    public function getElements(bool $force=false):Collection
    {
        if($this->_elements==null || $force){
            $this->_elements=Element::where('debat_id', '=', $this->getKey())->get();
        }

        return $this->_elements;
    }
}