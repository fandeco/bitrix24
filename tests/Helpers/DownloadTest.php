<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 25.04.2022
 * Time: 11:53
 */

namespace App\Tests\Helpers;

use App\Helpers\Download;
use App\Tests\TestCase;

class DownloadTest extends TestCase
{
    public function testGetEnv()
    {
        self::assertEquals('testing', getenv('ENV'));
    }

    public function testGet()
    {

        // Скачиваем
        $Download = new Download();

        $files = [
            'source' => '',
            'target' => '',
        ];

        foreach ($files as $item) {
            $Download->addFile($item['source'], $item['source']);
        }

        $results = null;
        // Скачивание целой директории
        if ($files = $Download->getFiles()) {
            // Разрешаем выкачивать по 20 файлов одновременно
            $limit = 20;
            $files = $Download->splitArray($files);
            foreach ($files as $array) {
                $results = $Download->aSyncRequest($array, true, $limit);
            }
        }


    }
}
