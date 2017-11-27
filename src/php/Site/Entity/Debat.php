<?php
/**
 * Created by PhpStorm.
 * User: cleme
 * Date: 26/11/2017
 * Time: 19:25
 */

namespace Site\Entity;


use Site\Entity;

class Debat extends Entity
{
    private $id;
    private $title;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }



}