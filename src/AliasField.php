<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 13.10.2022
 * Time: 07:32
 */

namespace Bitrix24;


class AliasField
{
    /**
     * @var string[]
     */
    public array $aliases;

    public function __construct()
    {
        $this->aliases = [
            'CHAT_ID' => 'UF_CRM_1665621150592',
            'ROISTAT_ID' => 'UF_CRM_1662118608905',
            'VISITOR_NUMBER' => 'UF_CRM_1665550327787',
            'PAGE_URL' => 'UF_CRM_1663927628378',
            'PAGE_TITLE' => 'UF_CRM_1663927675305',
            'SOURCE_1C' => 'UF_CRM_1665568341670',
        ];
    }

    public function get($key)
    {
        $aliases = $this->aliases();
        if (array_key_exists($key, $aliases)) {
            return $aliases[$key];
        }
        return null;
    }

    public function aliases()
    {
        return $this->aliases;
    }
}
