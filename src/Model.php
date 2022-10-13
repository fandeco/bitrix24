<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 13.10.2022
 * Time: 10:05
 */

namespace Bitrix24;

use Bitrix24\Abstracts\Models;
use Bitrix24\Interfaces\IMethod;
use Bitrix24\Interfaces\IModels;

class Model
{
    /**
     * @var string[]
     */
    protected $classes = [];

    public function __construct()
    {
        $this->classes = [
            'Lead' => \Bitrix24\Method\Crm\Lead\Get::class,
            'User' => \Bitrix24\Method\User\Get::class,
            'Contact' => \Bitrix24\Method\Crm\Contact\Get::class,
            'Company' => \Bitrix24\Method\Crm\Company\Get::class,
            'TimelineComment' => \Bitrix24\Method\Crm\Timeline\Comment\Get::class,
            'TimelineBindings' => \Bitrix24\Method\Crm\Timeline\Bindings\Get::class,
        ];
    }

    public function getClass($className)
    {
        if (array_key_exists($className, $this->classes)) {
            return $this->classes[$className];
        }
        return null;
    }

    /**
     * @param $className
     * @param $criteria
     * @return Models|null
     * @throws \Exception
     */
    public static function get($className, $criteria)
    {
        if (!$class = (new Model)->getClass($className)) {
            return null;
        }

        /* @var IMethod $Method */
        $Method = new $class();

        if (is_int($criteria)) {
            $Method->addParam('id', $criteria);
        } else {
            $Method->addParam('filter', $criteria);
        }

        $Method->addParam('select', ['*', 'UF_*']);

        $Bot = new Bot('API');
        $Client = $Bot->method($Method);

        try {
            if ($Object = $Client->request()) {
                $Object->_new = false;
                return $Object;
            }
        } catch (\Exception $e) {
            #$e->getMessage();
        }

        return null;
    }

    /**
     * @param $className
     * @param $criteria
     * @return Models\Crm\Lead\Get|null
     * @throws \Exception
     */
    public static function getList($className, array $filter, $orderBy = 'ID', $orderDir = 'DESC', $select = ['*', 'UF_*', 'PHONE', 'EMAIL', 'WEB'])
    {
        if (!$class = (new Model)->getClass($className)) {
            return null;
        }

        $class = substr($class, 0, -3) . 'GetList';


        /* @var IMethod $Method */
        $Method = new $class();

        $Method->addParam('filter', $filter)
            ->addParam('order', [
                $orderBy => $orderDir
            ])
            ->addParam('select', $select);

        if ($select) {
            $Method->addParam('select', $select);
        }


        $Bot = new Bot(getenv('BITRIX_BOT_DEFAULT'));
        $Client = $Bot->method($Method);
        try {
            return $Client->send();
        } catch (\Exception $e) {
            #$e->getMessage();
            return null;
        }
    }

    /**
     * @param string $className
     * @return Models|null
     */
    public static function create(string $className, $data = [])
    {
        if (!$class = (new Model)->getClass($className)) {
            return null;
        }
        $class = str_ireplace('Method', 'Models', $class);
        return (new $class($data));
    }

}
