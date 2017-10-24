<?php

namespace App\Services;

use InvalidArgumentException;

/**
 * Class ScheduleManager
 * @package App\Services
 */
class ScheduleManager
{
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
        return count($this->schedules);
    }

    /**
     * 讀取 schedule.json
     * @return void
     */
    public function processSchedules()
    {
        // 讀取 schedule.json
        $fileContent = file_get_contents(app_path() . '/../config/schedule.json');

        // json decode
        $scheduleArray = json_decode($fileContent, true);
        if (json_last_error() !== JSON_ERROR_NONE || !isset($scheduleArray['schedules'])) {
            throw new InvalidArgumentException('json file 格式錯誤');
        }

        // 將 schedule.json 內容整理成 Schedule[] $schedules
        $this->schedules = collect($scheduleArray['schedules'])->map(function($item) {
            // 檢查 schedule.json 各 schedule key 是否存在
            if (!$this->isScheduleFieldValid($item)) {
                throw new InvalidArgumentException('json file 格式錯誤');
            }

            return new Schedule($item);
        })->toArray();
    }

    /**
     * 檢查 schedule.json 各 schedule key 是否存在
     * @param array $schedule
     * @return bool
     */
    private function isScheduleFieldValid(array $schedule): bool
    {
        return isset($schedule['ext']) && isset($schedule['interval']) && isset($schedule['time']);
    }
}