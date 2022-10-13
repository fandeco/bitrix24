<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 15.07.2022
 * Time: 11:37
 */

namespace Fdc\Bitrix24\BotActions\Crm\Lead\Products;


use Fdc\Bitrix24\Abstracts\BotAction;

class Get extends BotAction
{
    protected $_uri = 'crm.lead.productrows.get';


    public function get()
    {
        $response = parent::get();
        if (!empty($response['result'])) {
            return $response['result'];
        }
        return null;
    }
}
