<?php

namespace App\Services;

/**
 * Class MyBackupService
 * @package App\Services
 */
class MyBackupService
{
    /*** @var JsonManager[] $managers */
    private $managers;

    /**
     * MyBackupService constructor.
     * @param ConfigManager $configManager
     * @param ScheduleManager $scheduleManager
     */
    public function __construct(ConfigManager $configManager, ScheduleManager $scheduleManager)
    {
        $this->managers[] = $configManager;
        $this->managers[] = $scheduleManager;
    }

    /**
     * 處理 json 設定檔
     * @return void
     */
    public function processJsonConfigs()
    {
        collect($this->managers)->each(function(JsonManager $manager) {
            $manager->processJsonConfig();
        });
    }

    /**
     * 測試驗證用
     * @return JsonManager[]
     */
    public function getManagers(): array
    {
        return $this->managers;
    }
}