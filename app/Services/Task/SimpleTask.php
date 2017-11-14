<?php

namespace App\Services\Task;

use App\Services\Candidate;
use App\Services\Config;
use App\Services\Schedule;

/**
 * Class SimpleTask
 * @package App\Services\Task
 */
class SimpleTask extends AbstractTask
{
    /**
     * 執行簡單備份
     * @param Config $config
     * @param Schedule $schedule
     * @return void
     */
    public function execute(Config $config, Schedule $schedule): void
    {
        parent::execute($config, $schedule);

        // 以 FileFinder 找到檔案的所有 handlers 後進行處理
        collect($this->fileFinder)->each(function (Candidate $candidate) {
            $this->broadcastToHandlers($candidate);
        });
    }
}