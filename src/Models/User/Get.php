<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 13.10.2022
 * Time: 09:03
 */

namespace Bitrix24\Models\User;


use Bitrix24\Abstracts\Models;
use Bitrix24\Interfaces\IMethod;
use Bitrix24\Interfaces\IModels;

/**
 * @property int $ID
 * @property string $NAME
 * @property string $LAST_NAME
 * @property string $SECOND_NAME
 * @property string $EMAIL
 * @property string $LAST_LOGIN
 * @property string $DATE_REGISTER
 */
class Get extends Models implements IModels
{

}
