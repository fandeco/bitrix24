<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 15.07.2022
 * Time: 11:37
 */

namespace Bitrix24\Method\Crm\Timeline\Comment;


use Bitrix24\Abstracts\Method;
use Bitrix24\Interfaces\IMethod;

class GetList extends Method implements IMethod
{
    protected $_uri = 'crm.timeline.comment.list';
}
