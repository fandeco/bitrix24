<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 08.09.2021
 * Time: 12:08
 */

namespace Bitrix24\Helpers;

use Bitrix24\Interfaces\IMethod;

class Client
{
    private static $ID = null;
    private static $NAME = null;
    private static $API_KEY = null;
    private static $HOOK = null;

    public function __construct($name, $id, $api_key, $hook = null)
    {
        self::$ID = $id;
        self::$NAME = $name;
        self::$API_KEY = $api_key;
        self::$HOOK = $hook ?: getenv('BITRIX_REST_API');
    }


    protected function botApiKey()
    {
        return self::$API_KEY;
    }


    protected function botId()
    {
        return self::$ID;
    }


    protected function botName()
    {
        return self::$NAME;
    }

    protected function botHook()
    {
        return self::$HOOK;
    }

    public function request(IMethod $Action)
    {
        $url = $this->botHook();
        $uri = $Action->uri();
        $Client = new RequestClient();
        $default = [
            'BOT_ID' => $this->botId(),
            'CLIENT_ID' => $this->botApiKey()
        ];
        $params = array_merge($default, $Action->toArray());
        $url = $url . $uri . '.json';
        $response = $Client->sendPost($url, $params);
        if ($response !== true) {
            $msg = null;
            $h = $Client->getResponseStr();
            if (!empty($h)) {
                $h = explode(PHP_EOL, $h);
                if (!empty($h)) {
                    $msgx = array_pop($h);
                    if (!empty($msgx)) {
                        $msg = $msgx;
                    }
                }
            }
            if (empty($msg)) {
                $msg = $Client->getMsg();
            }
            $errors = [
                'url' => $url,
                'msg' => $msg,
                'params' => $params,
            ];
            throw new \Exception($msg);
        }
        return $Client->getArray();
    }
}
