<?php

namespace Tests\Feature;

use App\Services\JsonManager;
use Tests\TestCase;
use App\Services\MyBackupService;
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

    public function test_有managers屬性()
    {
        $this->assertObjectHasAttribute('managers', $this->myBackupService);
    }

    public function test_執行處理json設定檔後_managers屬性有值且型態正確()
    {
        $this->myBackupService->processJsonConfigs();

        // 取得 managers 屬性，測試驗證用
        $managers = $this->myBackupService->getManagers();

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
}
