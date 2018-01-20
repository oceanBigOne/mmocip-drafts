<?php
/**
 * Project : mmocip-drafts
 * File : OnloadMessage.php
 */

namespace Site\Twig\Extension;


class OnloadMessage extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getOnloadMessage', array($this, 'getOnloadMessage'))
        );
    }


    public function getOnloadMessage()
    {
        $message="";
        $messageType="";
        if(isset($_POST["message"])){
            $message=$_POST["message"];
        }
        if(isset($_POST["messageType"])){
            $messageType=$_POST["messageType"];
        }

        return json_encode(["message"=>$message,"type"=>$messageType]);


    }



    public function getName()
    {
        return 'getOnloadMessage';
    }
}