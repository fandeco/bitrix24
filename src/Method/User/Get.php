<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 13.10.2022
 * Time: 12:17
 */

namespace Bitrix24\Method\User;


use Bitrix24\Abstracts\Method;
use Bitrix24\Interfaces\IMethod;

class Get extends Method implements IMethod
{
    protected $_uri = 'user.get';
}
