<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 13.10.2022
 * Time: 14:14
 */

namespace Tests\Models\Crm\Contact;

use Bitrix24\Model;
use Bitrix24\Models\Crm\Contact\Get;
use Tests\TestCase;

class GetTest extends TestCase
{
    public function testGet()
    {
        $id = 97305;
        $Object = Model::get('Contact', $id);
        echo '<pre>';
        print_r($Object->toArray());
        die;

    }
}
