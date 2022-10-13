<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 13.10.2022
 * Time: 09:08
 */

namespace Bitrix24\Abstracts;


use Bitrix24\Bot;
use Bitrix24\Interfaces\IMethod;
use Carbon\Carbon;
use ReflectionClass;

abstract class Models
{
    /**
     * Indicates if the instance is transient (and thus new).
     * @var boolean
     * @access public
     */
    public $_new = true;

    protected array $fieldsMap = [];
    protected array $aliases = [];
    protected array $aliasesArray = [];
    protected array $defaultFields = [];

    public function __construct($data = [])
    {

        $aliases = $this->aliases();
        foreach ($aliases as $alias => $key) {
            $this->defaultFields[$alias] = null;
        }

        $rc = new ReflectionClass(get_class($this));
        $out = $rc->getDocComment();
        $arrays = explode(PHP_EOL, $out);
        $this->map = [];
        foreach ($arrays as $str) {
            if (strripos($str, '@property') !== false) {
                $symbol = substr($str, 13);
                $arr = explode(' ', $symbol);
                $arr = array_map('trim', $arr);
                list($type, $field) = $arr;

                $field = str_ireplace('$', '', $field);
                $value = null;
                switch ($type) {
                    case 'string':
                        $value = '';
                        break;
                    case 'int':
                        $value = null;
                        break;
                    case 'boolean':
                        $value = false;
                        break;
                    default:
                        break;
                }


                $this->data[$field] = $value;
                $this->fieldsMap[$field] = $type;
            }
        }

        foreach ($this->defaultFields as $field => $value) {
            if (!array_key_exists($field, $this->data)) {
                $this->set($field, $value);
                $this->fieldsMap[$field] = 'string';
            }
        }


        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $data = $this->_format($key, $value);
                $this->data[$data['key']] = $data['value'];
            }
        }
    }

    public function fromArray(array $array)
    {
        $this->original = $array;
        foreach ($array as $key => $item) {
            $this->set($key, $item);
        }
        return $this;
    }

    protected function _format(string $key, $value)
    {
        $key = mb_strtoupper($key);
        $original_key = $this->getAlias($key, true);
        if (array_key_exists($original_key, $this->fieldsMap)) {
            $type = $this->fieldsMap[$original_key];
            switch ($type) {
                case 'array':
                    if (is_array($value)) {
                        $value = @$value[0]['VALUE'];
                    }

                    break;
                case 'int':
                    if (!empty($value)) {
                        $value = (int)$value;
                    }
                    break;
                case 'string':
                    $value = (string)$value;
                    break;
                case 'boolean':
                    if ($value === 'N') {
                        $value = false;
                    } else if ($value === 'Y') {
                        $value = true;
                    }
                    break;
                default:
                    break;
            }
        }
        return [
            'key' => $original_key,
            'value' => $value,
        ];
    }

    public function set(string $key, $value)
    {
        $oldValue = null;
        if (array_key_exists($key, $this->data)) {
            $oldValue = $this->data[$key];
        }
        $data = $this->_format($key, $value);
        $v = $data['value'];
        $key = $data['key'];
        $this->data[$key] = $v;
        if ($oldValue !== $v) {
            $this->setDirty($key);
        }
        return $this;
    }

    protected $_dirty = [];

    public function isDirty($field)
    {
        if (array_key_exists($field, $this->_dirty) || $this->isNew()) {
            return true;
        }
        return false;
    }
    public function getDirty()
    {
        return $this->_dirty;
    }


    /**
     * Add the field to a collection of field keys that have been modified.
     *
     * This function also clears any validation flag associated with the field.
     *
     * @param string $key The key of the field to set dirty.
     */
    public function setDirty($key = '')
    {
        if (empty($key)) {
            foreach (array_keys($this->fieldsMap) as $f => $fieldKey) {
                $this->setDirty($f);
            }
        } else {
            if (array_key_exists($key, $this->fieldsMap)) {
                $this->_dirty[$key] = $key;
            }
        }
    }

    public function toArray()
    {
        return $this->data;
    }

    public function aliases()
    {
        return $this->aliases;
    }

    /**
     * @param string $key
     * @param bool $revers
     * @return string
     */
    public function getAlias(string $key, bool $revers = false)
    {
        $aliases = $this->aliases();
        if ($revers) {
            $aliases = array_flip($aliases);
        }
        if (array_key_exists($key, $aliases)) {
            return $aliases[$key];
        }
        return $key;
    }

    public function setAlias(string $key, string $new)
    {
        $this->aliases[$key] = $new;
        return $this;
    }


    public function get(string $key)
    {
        $key = mb_strtoupper($key);
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
        return null;
    }


    private function getMethodClass(string $action)
    {
        $class = get_class($this);
        $classMethod = str_ireplace('Models', 'Method', $class);
        $classMethod = substr($classMethod, 0, -3);
        return $classMethod . $action;
    }

    public function id()
    {
        return $this->get('id');
    }

    public function delete()
    {
        if ($id = $this->id()) {
            $class = $this->getMethodClass('delete');
            $Method = new $class();
            $Method->addParam('id', $id);
            $Bot = new Bot(getenv('BITRIX_BOT_DEFAULT'));
            $Client = $Bot->method($Method);
            $response = $Client->send();
            return (bool)$response['result'];
        }
        return false;
    }


    public function add()
    {
        return $this->rawData('add');
    }

    public function update()
    {
        return $this->rawData('update');
    }

    /**
     * Indicates if the instance is new, and has not yet been persisted.
     *
     * @return boolean True if the object has not been saved or was loaded from
     * the database.
     */
    public function isNew()
    {
        return (boolean)$this->_new;
    }


    public function save()
    {
        if ($this->isNew()) {
            return $this->add();
        } else {
            return $this->update();
        }
    }

    private function getType($field)
    {
        if (array_key_exists($field, $this->fieldsMap)) {
            return $this->fieldsMap[$field];
        }
        return null;
    }

    private function rawData($action)
    {
        $action = ucfirst($action);
        $class = $this->getMethodClass($action);
        $Method = new $class();
        $data = $this->toArray();
        $Fields = $this->fieldsMap;
        $array = null;

        if ($this->isNew()) {
            $this->setDirty();
        }

        foreach ($data as $key => $val) {
            if ($type = $this->getType($key)) {
                if ($this->isDirty($key)) {
                    $original_key = $this->getAlias($key);
                    if (array_key_exists($original_key, $Fields)) {
                        $type = $Fields[$original_key];
                    }
                    switch ($type) {
                        case 'array':
                            $val = [[
                                'VALUE' => $val,
                                'VALUE_TYPE' => 'WORK'
                            ]];
                            break;
                        default:
                            break;
                    }
                    $array[$original_key] = $val;
                }
            }
        }


        if (!$array) {
            return true;
        }

        $Method->addParam('fields', $array);
        if ($this->isNew()) {
            $Method->addParam('params', [
                'REGISTER_SONET_EVENT' => 'Y' // уведомить о лиде
            ]);
        } else {
            $Method->addParam('id', $this->id());
        }


        $Bot = new Bot(getenv('BITRIX_BOT_DEFAULT'));
        $Client = $Bot->method($Method);
        $response = $Client->send();

        $this->_dirty = [];
        if (!empty($response['result'])) {
            if ($this->_new) {
                $this->set('id', $response['result']);
            }
            $this->_new = false;
            return true;
        }
        return false;
    }
}
