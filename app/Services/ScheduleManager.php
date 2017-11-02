<?php

namespace App\Services;

/**
 * Class ScheduleManager
 * @package App\Services
 */
class ScheduleManager extends JsonManager
{
    /** @var string 設定檔檔名 */
    const FILE_NAME = 'schedule.json';

    /** @var Schedule[] $schedules */
    private $schedules = [];

    /**
     * @return Schedule[]
     */
    public function getSchedules(): array
    {
        return $this->schedules;
    }

    /**
     * 計算 schedules 數量
     * @return int
     */
    public function count(): int
    {
        return $this->configCount($this->schedules);
    }

    /**
     * 將 json 設定檔處理成可讓外部使用的 array
     * @return void
     */
    public function processJsonConfig()
    {
        // 讀取 json 轉成 Collection Object
        $scheduleArray = $this->getJsonObject(self::FILE_NAME);

        // 將 schedule.json 內容整理成 Schedule[] $schedules
        $this->schedules = collect($scheduleArray->get('schedules', []))->map(function($item) {
            return new Schedule(collect($item));
        })->toArray();
    }
}