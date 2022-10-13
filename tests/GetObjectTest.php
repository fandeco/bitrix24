<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 13.10.2022
 * Time: 10:10
 */

namespace Tests;

use Bitrix24\Model;
use Bitrix24\Models\Crm\Lead\Get;
use Tests\TestCase;

class GetObjectTest extends TestCase
{
    public function testGetCompany()
    {
        $id = 21240;

        self::assertEquals($Object->get('id'), $id);
    }

    public function testGetContact()
    {
        $id = 21256;
        /* @var Get $Object */
        $Object = Model::get('Lead', $id);

        $Object->set('VISITOR_NUMBER', 2222221);
        $Object->save();


        echo '<pre>';
        print_r($Object->toArray());
        die;

        self::assertEquals($Object->get('id'), $id);
    }

    public function testGet()
    {
        $id = 21225;
        $Object = Model::get('Lead', $id);

        echo '<pre>';
        print_r($Object->toArray());
        die;

        self::assertEquals($Object->get('id'), $id);
    }


    public function testUpdate()
    {
        $id = 21225;
        $Object = Model::get('Lead', $id);
        $Object->set('phone', '999999');
        $Object->set('title', 'НОВЫЙ ЗАГОЛВОК2');


        $Object->set('COMMENTS', 'COMMENTS');


        $res = $Object->save();

        echo '<pre>';
        print_r($res);
        die;

        self::assertEquals($Object->get('id'), $id);
    }

    public function testGetList()
    {
        $Arrays = Model::getList('Lead', [
            'ID' => 21226
        ]);

        echo '<pre>';
        print_r($Arrays);
        die;

        self::assertEquals($Object->get('id'), $id);
    }


    public function testComment()
    {
        $id = 21225;

        /* @var Get $Object */
        $Object = Model::get('Lead', $id);


        $messages = [
            [
                'message' => "Добрый день!",
                'timestamp' => 1665594290,
                'type' => 'visitor',
            ],
            [
                'message' => "Подскажите пожалуйста, нужен такой светильник!",
                'timestamp' => 1665594306,
                'type' => 'visitor',
            ],
            [
                'message' => "Подскажите артикул",
                'timestamp' => 1665595533,
                'type' => 'agent',
                'agent_id' => 14,
            ]
        ];

        $msg = $Object->parserComments('Андрей', $messages);
        $Object->set('PHONE', '793333333');
        $Object->set('COMMENTS', $msg);
        $Object->save();

        echo '<pre>';
        print_r($Object->toArray());
        die;


        self::assertEquals($Object->get('id'), $id);
    }


    public function testCreate()
    {
        $Object = Model::create('Lead');
        $Object->set('phone', '79133313211');
        $Object->set('title', 'Привет проверь');
        self::assertTrue($Object->save());

        $Object = Model::get('Lead', $Object->id());
        self::assertTrue($Object->delete());

    }
}
