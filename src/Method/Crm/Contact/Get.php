<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 15.07.2022
 * Time: 11:37
 */

namespace Bitrix24\Method\Crm\Contact;

use Bitrix24\Abstracts\Method;
use Bitrix24\Interfaces\IMethod;

class Get extends Method implements IMethod
{
    protected $_uri = 'crm.contact.get';
}
