<?php
/**
 * Project : mmocip-drafts
 * File : Config.php
 */

namespace Site\Service;


/**
 * Class Config
 *
 * Service d'accès aux variables de config du site
 *
 * @package Site\Service
 */
class Config
{
    /**
     * @param string $sVarname
     * @return mixed
     */
    public static function get($sVarname)
    {
        global $CONFIG;

        if( !array_key_exists($sVarname, $CONFIG) )
        {
            return null;
        }

        return $CONFIG[ $sVarname ];
    }


}