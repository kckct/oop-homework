<?php

namespace App\Services\Task;

use App\Services\Config;
use App\Services\ConfigManager;
use App\Services\JsonManager;
use App\Services\Schedule;

/**
 * Class TaskDispatcher
 * @package App\Services\Task
 */
class TaskDispatcher
{
    /** @var Task $task */
    private $task;

    /**
     * 簡單備份的工作
     * @param JsonManager[] $managers
     * @return void
     */
    public function simpleTask(array $managers): void
    {
        // 建立簡單備份工作的物件
        $this->task = TaskFactory::create('simple');

        // 空的 Schedule 物件
        $schedule = new Schedule(collect([]));

        // 以 config.json 設定檔內容去執行工作
        collect($managers[0]->getConfigs())->each(function (Config $config) use ($schedule) {
            $this->task->execute($config, $schedule);
        });
    }

    /**
     * 排程備份的工作
     * @param JsonManager[] $managers
     * @return void
     */
    public function scheduledTask(array $managers): void
    {
        // 建立排程備份工作的物件
        $this->task = TaskFactory::create('scheduled');
    }
}