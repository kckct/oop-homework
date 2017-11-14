<?php

namespace App\Services\Task;

use App\Services\Config;
use App\Services\Schedule;

/**
 * Interface Task
 * @package App\Services\Task
 */
interface Task
{
    /**
     * 執行工作
     * @param Config $config
     * @param Schedule $schedule
     * @return void
     */
    public function execute(Config $config, Schedule $schedule): void;
}