<?php
/**
 * Project : mmocip-drafts
 * File : AjaxResponse.php
 */

namespace Site\Util;

/**
 * Class AjaxResponse
 *
 * Utilitaire permettant de construire des réponses AJAX formatée
 *
 * @package Site\Util
 */
class AjaxResponse
{
    /**
     * Données membres qui seront affichées au format JSON
     * @var array
     */
    private $data=[];

    /**
     * AjaxResponse constructor.
     */
    public function __construct()
    {
        $this->data=[];
        $this->data["message"]=null;
        $this->data["messageType"]=null;
        $this->data["callback"]=null;
        $this->data["redirect"]=null;
    }

    /**
     * Déclenche l'affichage d'un message
     * @param string $message message a affiché
     * @param string $type(success|error|info|warning] détermine le style à appliquer
     */
    public function setMessage(string $message,string $type="success"):void
    {
        $this->data["message"]=$message;
        $this->data["messageType"]=$type;
    }

    /**
     * Déclenche un callback
     * @param string $function  nom de la fonction a appelé
     * @param array $data paramètres de la fonctions (dans l'ordre arg1,arg2,...)
     * @param int $timeout
     */
    public function setCallback(string $function,array $data=[],int $timeout=0):void {

        if(!is_null($function)){
            $this->data["callback"]=[];
            $this->data["callback"]["function"]=$function;
            $this->data["callback"]["data"]=$data;
            $this->data["callback"]["timeout"]=$timeout;
        }else{
            $this->data["callback"]=null;
        }
    }

    /**
     * Déclenche une redirection
     * @param string $url url cible de la redirection
     * @param array $data paramètres à passer à la redirection
     * @param int $timeout
     */
    public function setRedirect(string $url,array $data=[],int $timeout=0):void{
        if(!is_null($url)){
            $this->data["redirect"]=[];
            $this->data["redirect"]["url"]=$url;
            $this->data["redirect"]["data"]=$data;
            $this->data["redirect"]["timeout"]=$timeout;
        }else{
            $this->data["redirect"]=null;
        }
    }

    /**
     * Déclenche une redirection avec un message affiché au chargement de la page
     * @param string $url url cible de la redirection
     * @param string $message message a affiché
     * @param string $type(success|error|info|warning] détermine le style à appliquer     *
     * @param array $data paramètres à passer à la redirection
     * @param int $timeout
     */
    public function setRedirectWithMessage(string $url,string $message="",string $type="success",array $data=[],int $timeout=0):void{
        $data["message"]=$message;
        $data["messageType"]=$type;
        $this->setRedirect($url,$data,$timeout);
    }


    /**
     * Renvoi le tableau construit
     * @return array
     */
    public function get():array{
        return $this->data;
    }


}