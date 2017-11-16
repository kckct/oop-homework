<?php

namespace Tests\Unit\Task;

use Illuminate\Support\Facades\Storage;
use App\Services\Task\ScheduledTask;
use App\Services\Schedule;
use App\Services\Config;
use Tests\TestCase;

/**
 * Class ScheduledTaskTest
 * @package Tests\Unit\Task
 */
class ScheduledTaskTest extends TestCase
{
    private $scheduledTask;

    public function setUp()
    {
        parent::setUp();

        $this->scheduledTask = new ScheduledTask();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function test_執行排程備份_現在時間加1hr_應會產生一個檔案()
    {
        // arrange
        // 產生測試用檔案
        $testFileName = 'ScheduledTaskTest.txt';
        Storage::put($testFileName, '123');
        // 測試執行時預期產生的檔案
        $byteArrayToFile = 'ScheduledTaskTest.txt.backup';
        // 測試完預期產生的檔案
        $copyToNewFile = 'backup/ScheduledTaskTest.txt.backup';

        $configStub = $this->createFakeConfig();
        $scheduleStub = $this->createFakeSchedule();

        // act
        $this->scheduledTask->execute($configStub, $scheduleStub);

        // assert
        // 查看是否有檔案產生
        $this->assertTrue(Storage::exists($testFileName));
        $this->assertFalse(Storage::exists($byteArrayToFile));
        $this->assertFalse(Storage::exists($copyToNewFile));

        // 測試結束刪除檔案
        Storage::delete($testFileName);
        $this->assertFalse(Storage::exists($testFileName));
    }

    public function test_執行排程備份_現在時間_應會產生三個檔案()
    {
        // arrange
        // 產生測試用檔案
        $testFileName = 'ScheduledTaskTest.txt';
        Storage::put($testFileName, '123');
        // 測試執行時預期產生的檔案
        $byteArrayToFile = 'ScheduledTaskTest.txt.backup';
        // 測試完預期產生的檔案
        $copyToNewFile = 'backup/ScheduledTaskTest.txt.backup';

        $configStub = $this->createFakeConfig();
        $scheduleStub = $this->createFakeScheduleNow();

        // act
        $this->scheduledTask->execute($configStub, $scheduleStub);

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
            'handler'          => ['zip', 'encode'],
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
            'time'     => date('H:i', strtotime('+1 hour')),
        ]);

        return new Schedule($item);
    }

    private function createFakeScheduleNow()
    {
        $item = collect([
            'ext'      => 'txt',
            'interval' => date('l'),
            'time'     => date('H:i'),
        ]);

        return new Schedule($item);
    }
}
