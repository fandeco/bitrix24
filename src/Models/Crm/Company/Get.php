<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 13.10.2022
 * Time: 09:03
 */

namespace Bitrix24\Models\Crm\Company;


use Bitrix24\Abstracts\Models;
use Bitrix24\Interfaces\IModels;
use Bitrix24\Model;

/**
 * @property int $ID
 * @property string $TITLE
 * @property array $PHONE
 * @property string $SOURCE_DESCRIPTION
 * @property string $DATE_CREATE
 * @property string $DATE_MODIFY
 */
class Get extends Models implements IModels
{

}
