<?php

namespace App\Services;

use App\Services\Task\TaskDispatcher;

/**
 * Class MyBackupService
 * @package App\Services
 */
class MyBackupService
{
    /*** @var JsonManager[] $managers */
    private $managers;

    /*** @var TaskDispatcher $taskDispatcher */
    private $taskDispatcher;

    /**
     * MyBackupService constructor.
     * @param ConfigManager $configManager
     * @param ScheduleManager $scheduleManager
     */
    public function __construct(ConfigManager $configManager, ScheduleManager $scheduleManager)
    {
        $this->managers[]     = $configManager;
        $this->managers[]     = $scheduleManager;
        $this->taskDispatcher = new TaskDispatcher();

        $this->init();
    }

    /**
     * 初始化設定
     * @return void
     */
    private function init(): void
    {
        // 處理 json 設定檔
        $this->processJsonConfigs();
    }

    /**
     * 處理 json 設定檔
     * @return void
     */
    private function processJsonConfigs(): void
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

    /**
     * 簡單備份
     * @return void
     */
    public function simpleBackup(): void
    {
        $this->taskDispatcher->simpleTask($this->managers);
    }

    /**
     * 排程備份
     * @return void
     */
    public function scheduledBackup(): void
    {
        while (true) {
            $this->taskDispatcher->scheduledTask($this->managers);

            // phpunit 只跑一次
            if (env('APP_ENV') === 'testing') {
                break;
            }
        }
    }
}