<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 08.09.2021
 * Time: 11:45
 */

namespace Bitrix24\Abstracts;

use Bitrix24\Exceptions\ExceptionClient;
use Bitrix24\Models\Crm\Lead\Get;
use Exception;

abstract class Method
{
    /*  @var array|null $_params */
    private $_params = null;
    protected $_uri;
    protected $action = null;

    protected function action(string $type)
    {
        $this->action = $type;
        return $this;
    }

    public function list()
    {
        return $this->action('list');
    }

    public function add()
    {
        return $this->action('add');
    }


    public function uri()
    {
        $uri = $this->_uri;
        if ($action = $this->action) {
            $this->action = null;
            $uri = $uri . '.' . $action;
        }
        return $uri;
    }


    /**
     * @param string $key
     * @param $value
     * @return $this
     */
    public function addParam(string $key, $value)
    {
        $this->_params[$key] = $value;
        return $this;
    }

    public function getParam($key)
    {
        return $this->_params[$key];
    }

    /**
     * @return array|null
     */
    public function toArray()
    {
        return $this->_params;
    }

    /**
     * @return array|null
     */
    public function start(int $count)
    {
        $this->addParam('start', $count);
        return $this;
    }

    /**
     * @return \Bitrix24\Models\Crm\Lead\Get
     */
    public function loadModel($result = [])
    {
        $value = str_ireplace('.', ' ', $this->_uri);
        $value = ucwords($value);
        $value = str_ireplace(' ', '\\', $value);
        $className = '\\Bitrix24\\Models\\' . $value;

        if (!class_exists($className)) {
            throw new ExceptionClient('Не удалось загрузить класс ' . $className);
        }

        $Model = new $className($result);
        return $Model;
    }
}



