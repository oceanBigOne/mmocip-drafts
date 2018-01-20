<?php
/**
 * Project : mmocip-drafts
 * File : AjaxResponse.php
 */

namespace Site\Util;


class AjaxResponse
{
    private $message=null;
    private $callback=null;


    public function __construct()
    {
        $this->data=[];
        $this->data["message"]=null;
        $this->data["messageType"]=null;
        $this->data["callback"]=null;
        $this->data["redirect"]=null;
    }

    public function setMessage($message,$type="success")
    {
        $this->data["message"]=$message;
        $this->data["messageType"]=$type;
    }


    public function setCallback($function,$data=[],$timeout=0){

        if(!is_null($function)){
            $this->data["callback"]=[];
            $this->data["callback"]["function"]=$function;
            $this->data["callback"]["data"]=$data;
            $this->data["callback"]["timeout"]=$timeout;
        }else{
            $this->data["callback"]=null;
        }
    }

    public function setRedirect($url,$data=[],$timeout=0){
        if(!is_null($url)){
            $this->data["redirect"]=[];
            $this->data["redirect"]["url"]=$url;
            $this->data["redirect"]["data"]=$data;
            $this->data["redirect"]["timeout"]=$timeout;
        }else{
            $this->data["redirect"]=null;
        }
    }

    public function setRedirectWithMessage($url,$message="",$type="success",$data=[],$timeout=0){
        $data["message"]=$message;
        $data["messageType"]=$type;
        $this->setRedirect($url,$data,$timeout);
    }


    public function get(){
        return $this->data;
    }


}