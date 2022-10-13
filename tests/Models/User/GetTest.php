<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 13.10.2022
 * Time: 12:19
 */

namespace Tests\Models\User;

use Bitrix24\Model;
use Bitrix24\Models\User\Get;
use Tests\TestCase;

class GetTest extends TestCase
{
    public function testGet()
    {
        $id = 14;
        $Object = Model::get('User', $id);

        echo '<pre>';
        print_r($Object->toArray());
        die;

    }
}
