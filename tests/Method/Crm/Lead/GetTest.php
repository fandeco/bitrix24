<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 13.10.2022
 * Time: 08:38
 */

namespace Tests\Method\Crm\Lead;

use Bitrix24\Bot;
use Bitrix24\Method\Crm\Lead\Add;
use Bitrix24\Method\Crm\Lead\Get;
use Tests\TestCase;

class GetTest extends TestCase
{
    public function testGet()
    {
        $Add = new Get();
        $Add->addParam('id', 21228);

        $Bot = new Bot('API');

        $Client = $Bot->method($Add);
        $Object = $Client->request();

        echo '<pre>';
        print_r($Object->toArray());
        die;

    }
}
