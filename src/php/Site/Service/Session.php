<?php

/**
 * Project : mmocip-drafts
 */

namespace Site\Service;

/**
 * Class Session
 *
 * Service d'accès aux variables de session du site
 *
 * @package Site\Service
 *
 **/
class Session
{
    /**
     * @param string $sVarname
     * @param bool $bSerialize
     * @param mixed $mValue
     */
    public static function set($sVarname, $mValue, $bSerialize=false)
    {
        $sIdSite = Config::get("sessiondomain");
        $key = $sIdSite.$sVarname;

        if( $bSerialize===true )
        {
            $mValue = serialize($mValue);
        }

        $_SESSION[ $key ] = $mValue;
    }

    /**
     * @param string $sVarname
     * @param bool $bUnserialize
     * @return mixed
     */
    public static function get($sVarname, $bUnserialize=false)
    {
        $sIdSite = Config::get("sessiondomain");
        $key = $sIdSite.$sVarname;
        $sReturn = null;


        if( array_key_exists($key, $_SESSION) )
        {
            $sReturn = $_SESSION[ $key ];

            if( $bUnserialize===true )
            {
                $sReturn = unserialize($sReturn);
            }
        }

        return $sReturn;
    }


    /**
     *  vide toutes les variables de sessions
     */
    public static function clear()
    {
        $sIdSite = Config::get("sessiondomain");
        foreach($_SESSION as $sKey=>$sValue){
            if( substr($sKey,0,strlen($sIdSite))== $sIdSite){
                $_SESSION[$sKey]=null;
            }
        }


    }
}