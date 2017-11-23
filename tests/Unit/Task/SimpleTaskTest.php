<?php

namespace Tests\Unit\Task;

use Illuminate\Support\Facades\Storage;
use App\Services\Schedule;
use App\Services\Config;
use App\Services\Task\SimpleTask;
use Tests\TestCase;

/**
 * Class SimpleTaskTest
 * @package Tests\Unit\Task
 */
class SimpleTaskTest extends TestCase
{
    private $simpleTask;

    public function setUp()
    {
        parent::setUp();

        $this->simpleTask = new SimpleTask();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function test_執行簡單備份_應會產生三個檔案()
    {
        // arrange
        // 產生測試用檔案
        $testFileName = 'SimpleTaskTest.txt';
        Storage::put($testFileName, '123');
        // 測試執行時預期產生的檔案
        $byteArrayToFile = 'SimpleTaskTest.txt.backup';
        // 測試完預期產生的檔案
        $copyToNewFile = 'backup/SimpleTaskTest.txt.backup';

        $configStub = $this->createFakeConfig();
        $scheduleStub = $this->createFakeSchedule();

        // act
        $this->simpleTask->execute($configStub, $scheduleStub);

        // assert
        // 查看是否有檔案產生
        $this->assertTrue(Storage::exists($testFileName));
        $this->assertTrue(Storage::exists($byteArrayToFile));
        $this->assertTrue(Storage::exists($copyToNewFile));

        // 測試結束刪除檔案
        Storage::delete($testFileName);
        $this->assertFalse(Storage::exists($testFileName));
        Storage::delete($copyToNewFile);
        $this->assertFalse(Storage::exists($copyToNewFile));
        Storage::delete($byteArrayToFile);
        $this->assertFalse(Storage::exists($byteArrayToFile));
    }

    private function createFakeConfig()
    {
        $item = collect([
            'ext'              => 'txt',
            'location'         => 'D:\\Projects\\oop-homework\\storage\\app',
            'subDirectory'     => true,
            'unit'             => 'file',
            'remove'           => false,
            'handlers'         => ['zip', 'encode'],
            'destination'      => 'directory',
            'dir'              => 'D:\\Projects\\oop-homework\\storage\\app\\backup',
            'connectionString' => '',
        ]);

        return new Config($item);
    }

    private function createFakeSchedule()
    {
        $item = collect([
            'ext'      => 'txt',
            'interval' => 'Everyday',
            'time'     => '12:00',
        ]);

        return new Schedule($item);
    }
}
