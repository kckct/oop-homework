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
    /**
     * Names of days of the week.
     *
     * @var array
     */
    const DAY_NAME_MAPPING = [
        'SUNDAY' => 0,
        'MONDAY' => 'Monday',
        'TUESDAY' => 'Tuesday',
        'WEDNESDAY' => 'Wednesday',
        'THURSDAY' => 'Thursday',
        'FRIDAY' => 'Friday',
        'SATURDAY' => 'Saturday',
    ];

    /**
     * 執行排程備份
     * @param Config $config
     * @param Schedule $schedule
     * @return void
     */
    public function execute(Config $config, Schedule $schedule): void
    {
        parent::execute($config, $schedule);

        // 檢查 Schedule 內設定的時間是否符合
        $scheduleInterval = strtoupper($schedule->getInterval());
        $dayName = strtoupper(date('l'));

        if ($scheduleInterval !== 'EVERYDAY' && ($scheduleInterval !== $dayName)) {
            return;
        }

        $scheduleTime = explode(':', $schedule->getTime());
        $now = Carbon::now();

        if ($now->hour !== (int)$scheduleTime[0] || $now->minute !== (int)$scheduleTime[1]) {
            return;
        }

        // 以 FileFinder 找到檔案的所有 handlers 後進行處理
        collect($this->fileFinder)->each(function (Candidate $candidate) {
            $this->broadcastToHandlers($candidate);
        });
    }
}