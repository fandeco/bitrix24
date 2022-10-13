<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 13.10.2022
 * Time: 15:11
 */

namespace Tests\Method\Crm\Timeline\Comment;

use Bitrix24\Method\Crm\Timeline\Comment\GetList;
use Bitrix24\Model;
use Bitrix24\Models\Crm\Lead\Get;
use Tests\TestCase;

class GetListTest extends TestCase
{
    public function testGetCompany()
    {

      /*  $arrays = Model::getList('TimelineComment', [
            "ENTITY_TYPE" => "lead",
            "ENTITY_ID" => 21240
        ], 'CREATED', 'DESC', ["ID", 'TITLE', 'LEGEND', 'CREATED', "ENTITY_ID ", "ENTITY_TYPE", 'AUTHOR_ID', 'COMMENT', 'FILES']);*/


        /* @var Get $Object */
        $Comment = Model::get('TimelineComment', 169000);

        echo '<pre>';
        print_r($Comment->toArray());
        die;


    }
}
