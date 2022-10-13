<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 08.09.2021
 * Time: 12:08
 */

namespace Bitrix24;

use Bitrix24\Abstracts\Method;
use Bitrix24\Helpers\RequestClient;
use Bitrix24\Interfaces\IMethod;

class Client
{
    private static $ID = null;
    private static $NAME = null;
    private static $API_KEY = null;
    private static $HOOK = null;
    /**
     * @var RequestClient
     */
    private $client;

    /* @var Method $method */
    private $method;

    public function __construct($name, $id, $api_key, $hook = null)
    {
        self::$ID = $id;
        self::$NAME = $name;
        self::$API_KEY = $api_key;
        self::$HOOK = $hook ?: getenv('BITRIX_REST_API');

        $this->client = new RequestClient();
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

    public function params()
    {
        return $this->params;
    }

    public function url()
    {
        return $this->url;
    }

    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }

    public function setUrl(string $url)
    {
        $this->url = $url;
        return $this;
    }

    public function setRequest(IMethod $Method)
    {
        $this->setMethod($Method);
        $url = $this->botHook();
        $uri = $Method->uri();

        $default = [
            'BOT_ID' => $this->botId(),
            'CLIENT_ID' => $this->botApiKey()
        ];
        $this->setParams(array_merge($default, $Method->toArray()));
        $this->setUrl($url . $uri . '.json');
        return $this;
    }


    public function request()
    {
        $data = $this->send();
        $result = $data['result'];
        if (!empty($data['result'][0])) {
            $result = $data['result'][0];
        }
        return $this->getMethod()->loadModel()->fromArrayFirst($result);
    }

    public function send()
    {
        $response = $this->client->sendPost($this->url(), $this->params());
        if ($response !== true) {
            $msg = null;
            $h = $this->client->getResponseStr();
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
                $msg = $this->client->getMsg();
            }
            throw new \Exception($msg);
        }
        return $this->client->getArray();
    }

    /**
     * @return Method
     */
    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod(IMethod $method)
    {
        $this->method = $method;
        return $this;
    }


    public function toArray()
    {
        return $this->client->getArray();
    }
}
