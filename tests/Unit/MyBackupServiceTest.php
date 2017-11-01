<?php

namespace Tests\Unit;

use App\Services\Candidate;
use App\Services\Config;
use Illuminate\Support\Facades\Storage;
use Mockery as M;
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
        $this->myBackupService->processJsonConfigs();

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

    public function test_執行備份doBackup會執行四個Handler_應會產生三個檔案()
    {
        // arrange
        // 產生測試用檔案
        $testFileName = 'test.txt';
        Storage::put($testFileName, '123');
        // 測試執行時預期產生的檔案
        $byteArrayToFile = 'test.txt.backup';
        // 測試完預期產生的檔案
        $copyToNewFile = 'backup/test.txt.backup';

        // 產生假 Candidate 物件
        $candidateStub = $this->createFakeCandidate();

        // act
        $myBackupService = M::mock(MyBackupService::class)->makePartial();
        $myBackupService->shouldReceive('findFiles')->once()->andReturn([$candidateStub]);
        $myBackupService->doBackup();

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

    private function createFakeCandidate()
    {
        $configItem = collect([
            'ext'              => 'txt',
            'location'         => 'D:\\Projects\\oop-homework\\storage\\app',
            'subDirectory'     => true,
            'unit'             => 'file',
            'remove'           => false,
            'handler'          => ['encode', 'zip'],
            'destination'      => 'directory',
            'dir'              => 'D:\\Projects\\oop-homework\\storage\\app\\backup',
            'connectionString' => '',
        ]);
        $configStub = new Config($configItem);

        $candidateItem = collect([
            'config'       => $configStub,
            'fileDateTime' => '2017-11-01 12:34:56',
            'name'         => 'test.txt',
            'processName'  => 'xxx',
            'size'         => '123',
        ]);

        return new Candidate($candidateItem);
    }
}
