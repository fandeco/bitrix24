<?php
/**
 * Работа с ботами для чатов
 * Что умеет
 * - регистрировать команды у себ
 * - отправлять сообщения
 */

namespace Bitrix24;

use Bitrix24\Interfaces\IMethod;

class Bot
{
    private int $bot_id;
    /**
     * @var mixed|string
     */
    private $bot_name;
    /**
     * @var mixed|string
     */
    private $bot_rest;
    /**
     * @var mixed|string
     */
    private $bot_client_id;
    /**
     * @var mixed|string
     */
    private $bot_hook;

    /**
     * @param string $bot_name [Api,Tasker,Докладун]
     * @throws \Exception
     */
    public function __construct(string $bot_name)
    {
        if (!$this->findBot($bot_name)) {
            throw new \Exception('Не удалось найти бота');
        }
    }

    /**
     * Находит бота
     * @param $name
     */
    private function findBot($name)
    {
        $name = mb_strtolower($name);
        $BITRIX_BOTS = getenv('BITRIX_BOTS');
        $BITRIX_BOTS = explode(',', $BITRIX_BOTS);
        foreach ($BITRIX_BOTS as $BITRIX_BOT) {
            list($bot_name, $bot_id, $bot_client_id, $bot_rest) = explode(':', $BITRIX_BOT);
            if (mb_strtolower($bot_name) === $name) {
                $this->bot_name = $bot_name;
                $this->bot_id = $bot_id;
                $this->bot_client_id = $bot_client_id;
                $this->bot_rest = $bot_rest;
                $url = getenv('BITRIX_REST_API');
                $url = rtrim($url, '/') . '/';
                $this->bot_hook = $url . $bot_rest . '/';
                return true;
            }
        }
        return false;
    }

    public function botName()
    {
        return $this->bot_name;
    }

    private function botClientId()
    {
        return $this->bot_client_id;
    }

    private function botId()
    {
        return $this->bot_id;
    }


    private function botRest()
    {
        return $this->bot_rest;
    }

    protected function webHook()
    {
        return $this->bot_hook;
    }

    private function client()
    {
        return new Client($this->botName(), $this->botId(), $this->botClientId(), $this->webHook());
    }


    /*public function msgObject(IMethod $Msg)
    {
        return $this->object($Msg);
    }


    public function object(IMethod $Msg)
    {
        return $this->client()->request($Msg);
    }*/


    public function method(IMethod $Method)
    {
        return $this->client()->setRequest($Method);
    }
}
