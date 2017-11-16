<?php

namespace Tests\Unit\Task;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Services\ConfigManager;
use App\Services\ScheduleManager;
use App\Services\Task\TaskDispatcher;
use Tests\TestCase;

/**
 * Class TaskDispatcherTest
 * @package Tests\Unit\Task
 */
class TaskDispatcherTest extends TestCase
{
    private $taskDispatcher;

    public function setUp()
    {
        parent::setUp();

        $this->taskDispatcher = new TaskDispatcher();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function test_執行簡單備份的工作_應會產生三個檔案()
    {
        // arrange
        // 產生測試用檔案
        $testFileName = 'TaskDispatcherTest.txt';
        Storage::put($testFileName, '123');
        // 測試執行時預期產生的檔案
        $byteArrayToFile = 'TaskDispatcherTest.txt.backup';
        // 測試完預期產生的檔案
        $copyToNewFile = 'backup/TaskDispatcherTest.txt.backup';

        $configManager = new ConfigManager();
        $configManager->processJsonConfig();
        $managersStub[] = $configManager;

        $scheduleManager = new ScheduleManager();
        $scheduleManager->processJsonConfig();
        $managersStub[] = $scheduleManager;

        // act
        $this->taskDispatcher->simpleTask($managersStub);

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

    public function test_執行排程備份的工作_應會產生四個檔案()
    {
        // arrange
        // 產生測試用檔案
        $testJsonFile = 'D:\\Projects\\oop-homework\\config\\test-schedule.json';
        $content = '
            {
                "schedules": [
                    {
                        "ext": "txt",
                        "time": "' . date('H:i') . '",
                        "interval": "Everyday"
                    }
                ]
            }
        ';
        File::put($testJsonFile, $content);
        $testFileName = 'TaskDispatcherTest.txt';
        Storage::put($testFileName, '123');
        // 測試執行時預期產生的檔案
        $byteArrayToFile = 'TaskDispatcherTest.txt.backup';
        // 測試完預期產生的檔案
        $copyToNewFile = 'backup/TaskDispatcherTest.txt.backup';

        $configManager = new ConfigManager();
        $configManager->processJsonConfig();
        $managersStub[] = $configManager;

        // 蓋掉 ScheduleManager const FILE_NAME，改用測試用 json
        $scheduleManagerStub = new class extends ScheduleManager {
            const FILE_NAME = 'test-schedule.json';
        };
        $scheduleManagerStub->processJsonConfig();
        $managersStub[] = $scheduleManagerStub;

        // act
        $this->taskDispatcher->scheduledTask($managersStub);

        // assert
        // 查看是否有檔案產生
        $this->assertTrue(File::exists($testJsonFile));
        $this->assertTrue(Storage::exists($testFileName));
        $this->assertTrue(Storage::exists($byteArrayToFile));
        $this->assertTrue(Storage::exists($copyToNewFile));

        // 測試結束刪除檔案
        File::delete($testJsonFile);
        $this->assertFalse(File::exists($testJsonFile));
        Storage::delete($testFileName);
        $this->assertFalse(Storage::exists($testFileName));
        Storage::delete($copyToNewFile);
        $this->assertFalse(Storage::exists($copyToNewFile));
        Storage::delete($byteArrayToFile);
        $this->assertFalse(Storage::exists($byteArrayToFile));
    }
}
