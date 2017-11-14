<?php

namespace App\Services\Task;

use App\Services\Candidate;
use App\Services\Config;
use App\Services\File\FileFinder;
use App\Services\File\FileFinderFactory;
use App\Services\Handler\Handler;
use App\Services\Handler\HandlerFactory;
use App\Services\Schedule;

/**
 * Class AbstractTask
 * @package App\Services\Task
 */
abstract class AbstractTask implements Task
{
    /*** @var FileFinder */
    protected $fileFinder;

    /**
     * 執行共用的工作
     * @param Config $config
     * @param Schedule $schedule
     * @return void
     */
    public function execute(Config $config, Schedule $schedule): void
    {
        // 建立 file 的 FileFinder
        $this->fileFinder = FileFinderFactory::create('file', $config);
    }

    /**
     * 找到檔案的所有 handlers 後進行處理
     * @param Candidate $candidate
     * @return void
     */
    protected function broadcastToHandlers(Candidate $candidate): void
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