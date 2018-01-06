<?php
/**
 * Project : mmocip-drafts
 * File : ConfigService.php
 */

namespace Site\Service;


class ConfigService
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