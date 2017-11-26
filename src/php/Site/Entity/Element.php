<?php
/**
 * Created by PhpStorm.
 * User: cleme
 * Date: 26/11/2017
 * Time: 19:26
 */

namespace Site\Entity;


class Element
{
    private $id;
    private $content;
    private $is_agree;
    private $is_disagree;
    private $is_question;
    private $is_missing_source;
    private $is_link;
    private $is_emote;
    private $relevance;
    private $parent_element_id;
    private $brother_element_id;
    private $debat_id;
    private $order;
    private $logical_connector;
    private $emoticon;

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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getisAgree()
    {
        return $this->is_agree;
    }

    /**
     * @param mixed $is_agree
     */
    public function setIsAgree($is_agree)
    {
        $this->is_agree = $is_agree;
    }

    /**
     * @return mixed
     */
    public function getisDisagree()
    {
        return $this->is_disagree;
    }

    /**
     * @param mixed $is_disagree
     */
    public function setIsDisagree($is_disagree)
    {
        $this->is_disagree = $is_disagree;
    }

    /**
     * @return mixed
     */
    public function getisQuestion()
    {
        return $this->is_question;
    }

    /**
     * @param mixed $is_question
     */
    public function setIsQuestion($is_question)
    {
        $this->is_question = $is_question;
    }

    /**
     * @return mixed
     */
    public function getisMissingSource()
    {
        return $this->is_missing_source;
    }

    /**
     * @param mixed $is_missing_source
     */
    public function setIsMissingSource($is_missing_source)
    {
        $this->is_missing_source = $is_missing_source;
    }

    /**
     * @return mixed
     */
    public function getisLink()
    {
        return $this->is_link;
    }

    /**
     * @param mixed $is_link
     */
    public function setIsLink($is_link)
    {
        $this->is_link = $is_link;
    }

    /**
     * @return mixed
     */
    public function getisEmote()
    {
        return $this->is_emote;
    }

    /**
     * @param mixed $is_emote
     */
    public function setIsEmote($is_emote)
    {
        $this->is_emote = $is_emote;
    }

    /**
     * @return mixed
     */
    public function getRelevance()
    {
        return $this->relevance;
    }

    /**
     * @param mixed $relevance
     */
    public function setRelevance($relevance)
    {
        $this->relevance = $relevance;
    }

    /**
     * @return mixed
     */
    public function getParentElementId()
    {
        return $this->parent_element_id;
    }

    /**
     * @param mixed $parent_element_id
     */
    public function setParentElementId($parent_element_id)
    {
        $this->parent_element_id = $parent_element_id;
    }

    /**
     * @return mixed
     */
    public function getBrotherElementId()
    {
        return $this->brother_element_id;
    }

    /**
     * @param mixed $brother_element_id
     */
    public function setBrotherElementId($brother_element_id)
    {
        $this->brother_element_id = $brother_element_id;
    }

    /**
     * @return mixed
     */
    public function getDebatId()
    {
        return $this->debat_id;
    }

    /**
     * @param mixed $debat_id
     */
    public function setDebatId($debat_id)
    {
        $this->debat_id = $debat_id;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return mixed
     */
    public function getLogicalConnector()
    {
        return $this->logical_connector;
    }

    /**
     * @param mixed $logical_connector
     */
    public function setLogicalConnector($logical_connector)
    {
        $this->logical_connector = $logical_connector;
    }

    /**
     * @return mixed
     */
    public function getEmoticon()
    {
        return $this->emoticon;
    }

    /**
     * @param mixed $emoticon
     */
    public function setEmoticon($emoticon)
    {
        $this->emoticon = $emoticon;
    }

}