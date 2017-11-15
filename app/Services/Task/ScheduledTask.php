<?php

namespace App\Services\Task;

use App\Services\Candidate;
use App\Services\Config;
use App\Services\Schedule;
use Carbon\Carbon;

/**
 * Class ScheduledTask
 * @package App\Services\Task
 */
class ScheduledTask extends AbstractTask
{
    /** @var string 每天 */
    const INTERVAL_EVERYDAY = 'EVERYDAY';

    /**
     * 執行排程備份
     * @param Config $config
     * @param Schedule $schedule
     * @return void
     */
    public function execute(Config $config, Schedule $schedule): void
    {
        parent::execute($config, $schedule);

        // 取 Schedule 內設定的時間 interval
        $scheduleInterval = strtoupper($schedule->getInterval());

        // 取 今天 interval
        $dayName = strtoupper(date('l'));

        // 1. interval 設定為 Everyday 的不檢查
        // 2. interval 設定與現在不同則中斷
        if ($scheduleInterval !== self::INTERVAL_EVERYDAY && ($scheduleInterval !== $dayName)) {
            return;
        }

        // 取 Schedule 內設定的時間 time 並切為時與分
        $scheduleTime = explode(':', $schedule->getTime());

        // 取 今天 time
        $now = Carbon::now();

        // hour & minute 設定與現在不同則中斷
        if ($now->hour !== (int)$scheduleTime[0] || $now->minute !== (int)$scheduleTime[1]) {
            return;
        }

        // 以 FileFinder 找到檔案的所有 handlers 後進行處理
        collect($this->fileFinder)->each(function (Candidate $candidate) {
            $this->broadcastToHandlers($candidate);
        });
    }
}