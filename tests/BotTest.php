<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 13.10.2022
 * Time: 08:36
 */

namespace Tests;

use Bitrix24\Bot;
use Tests\TestCase;

class BotTest extends TestCase
{

    public function testBotName()
    {
        $Bot = new Bot('API');
        self::assertEquals($Bot->botName(), 'API');
    }

}
