<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Tests\TestCase;
use App\Services\MyBackupService;
use App\Services\JsonManager;
use App\Services\ConfigManager;
use App\Services\ScheduleManager;

/**
 * Class MyBackupServiceTest
 * @package Tests\Feature
 */
class MyBackupServiceTest extends TestCase
{
    use RefreshDatabase;

    private $myBackupService;

    public function setUp()
    {
        parent::setUp();

        $this->myBackupService = new MyBackupService(new ConfigManager(), new ScheduleManager());
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function test_有managers屬性()
    {
        // assert
        $this->assertObjectHasAttribute('managers', $this->myBackupService);
    }

    public function test_執行處理json設定檔後_managers屬性有值且型態正確()
    {
        // act
        // 取得 managers 屬性，測試驗證用
        $managers = $this->myBackupService->getManagers();

        // assert
        // managers 屬性為 array
        $this->assertTrue(is_array($managers));
        // $managers[0] 及 $managers[1] 為 JsonManager
        $this->assertInstanceOf(JsonManager::class, $managers[0]);
        $this->assertInstanceOf(JsonManager::class, $managers[1]);
        // $managers[0] 也為 ConfigManager
        $this->assertInstanceOf(ConfigManager::class, $managers[0]);
        // $managers[1] 也為 ScheduleManager
        $this->assertInstanceOf(ScheduleManager::class, $managers[1]);
    }

    public function test_執行備份simpleBackup會執行四個Handler_應會產生四個檔案且寫入資料庫my_backup及my_log()
    {
        // arrange
        // 產生測試用檔案
        $testFileName = 'test.txt';
        Storage::put($testFileName, '123');
        // 測試執行時預期產生的檔案
        $byteArrayToFile = 'test.txt.backup';
        // 測試完預期產生的檔案
        $copyToNewFile = 'backup/test.txt.backup';
        $testFileName2 = 'test.docx';
        Storage::put($testFileName2, '123');

        // act
        $this->myBackupService->simpleBackup();

        // assert
        // 查看是否有檔案產生
        $this->assertTrue(Storage::exists($testFileName));
        $this->assertTrue(Storage::exists($byteArrayToFile));
        $this->assertTrue(Storage::exists($copyToNewFile));
        $this->assertTrue(Storage::exists($testFileName2));

        // 測試結束刪除檔案
        Storage::delete($testFileName);
        $this->assertFalse(Storage::exists($testFileName));
        Storage::delete($copyToNewFile);
        $this->assertFalse(Storage::exists($copyToNewFile));
        Storage::delete($byteArrayToFile);
        $this->assertFalse(Storage::exists($byteArrayToFile));
        Storage::delete($testFileName2);
        $this->assertFalse(Storage::exists($testFileName2));

        // 應寫入 my_backup
        $this->assertDatabaseHas('my_backup', [
            'name' => 'D:\\Projects\\oop-homework\\storage\\app\\test.docx',
        ]);

        // 應寫入 my_log
        $this->assertDatabaseHas('my_log', [
            'name' => 'D:\\Projects\\oop-homework\\storage\\app\\test.docx',
        ]);
    }

    public function test_執行備份scheduledBackup_Everyday且現在時間_會執行四個Handler_應會產生四個檔案()
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
        $testFileName = 'test.txt';
        Storage::put($testFileName, '123');
        // 測試執行時預期產生的檔案
        $byteArrayToFile = 'test.txt.backup';
        // 測試完預期產生的檔案
        $copyToNewFile = 'backup/test.txt.backup';

        // act
        // 蓋掉 ScheduleManager const FILE_NAME，改用測試用 json
        $scheduleManagerStub = new class extends ScheduleManager {
            const FILE_NAME = 'test-schedule.json';
        };
        $myBackupService = new MyBackupService(new ConfigManager(), $scheduleManagerStub);
        $myBackupService->scheduledBackup();

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

    public function test_執行備份scheduledBackup_Monday且現在時間加1小時_不會執行Handler_應會產生兩個檔案()
    {
        // arrange
        // 產生測試用檔案
        $testJsonFile = 'D:\\Projects\\oop-homework\\config\\test-schedule.json';
        $content = '
            {
                "schedules": [
                    {
                        "ext": "txt",
                        "time": "' . date('H:i', strtotime('+1 hour')) . '",
                        "interval": "Monday"
                    }
                ]
            }
        ';
        File::put($testJsonFile, $content);
        $testFileName = 'test.txt';
        Storage::put($testFileName, '123');
        // 測試執行時預期產生的檔案
        $byteArrayToFile = 'test.txt.backup';
        // 測試完預期產生的檔案
        $copyToNewFile = 'backup/test.txt.backup';

        // act
        // 蓋掉 ScheduleManager const FILE_NAME，改用測試用 json
        $scheduleManagerStub = new class extends ScheduleManager {
            const FILE_NAME = 'test-schedule.json';
        };
        $myBackupService = new MyBackupService(new ConfigManager(), $scheduleManagerStub);
        $myBackupService->scheduledBackup();

        // assert
        // 查看是否有檔案產生
        $this->assertTrue(File::exists($testJsonFile));
        $this->assertTrue(Storage::exists($testFileName));
        $this->assertFalse(Storage::exists($byteArrayToFile));
        $this->assertFalse(Storage::exists($copyToNewFile));

        // 測試結束刪除檔案
        File::delete($testJsonFile);
        $this->assertFalse(File::exists($testJsonFile));
        Storage::delete($testFileName);
        $this->assertFalse(Storage::exists($testFileName));
    }
}
