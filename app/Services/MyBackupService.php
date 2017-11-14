<?php

namespace App\Services;

use App\Services\File\FileFinderFactory;
use App\Services\Handler\Handler;
use App\Services\Handler\HandlerFactory;

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
    public function processJsonConfigs(): void
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
     * 執行備份
     * @return void
     */
    public function doBackup(): void
    {
        collect($this->managers[0]->getConfigs())->each(function (Config $config) {
            // 建立 file 的 FileFinder
            $fileFinder = FileFinderFactory::create('file', $config);

            // 以 FileFinder 找到檔案的所有 handlers 後進行處理
            collect($fileFinder)->each(function (Candidate $candidate) {
                $this->broadcastToHandlers($candidate);
            });
        });
    }

    /**
     * 找到檔案的所有 handlers 後進行處理
     * @param Candidate $candidate
     * @return void
     */
    private function broadcastToHandlers(Candidate $candidate): void
    {
        // 找到檔案的所有 handlers
        $handlers = $this->findHandlers($candidate);

        // byte[]
        $target = [];

        // 依不同的 handler 處理檔案
        foreach ($handlers as $handler) {
            $target = $handler->perform($candidate, $target);
        }
    }

    /**
     * 找到檔案的所有 handlers
     * @param Candidate $candidate
     * @return Handler[]
     */
    private function findHandlers(Candidate $candidate): array
    {
        // 加入 處理檔案
        $handlers[] = HandlerFactory::create('file');

        // 加入 config.json 內設定的 handler
        foreach ($candidate->getConfig()->getHandler() as $handler) {
            $handlers[] = HandlerFactory::create($handler);
        }

        // 加入 處理檔案儲存目的
        $handlers[] = HandlerFactory::create($candidate->getConfig()->getDestination());

        return $handlers;
    }
}