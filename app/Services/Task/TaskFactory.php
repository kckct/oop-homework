<?php

namespace App\Services\Task;

use InvalidArgumentException;

/**
 * Class TaskFactory
 * @package App\Services\Task
 */
class TaskFactory
{
    /**
     * 建立對應的 Task object
     * @param string $task
     * @return Task
     */
    public static function create(string $task): Task
    {
        if ($task === 'simple') {
            return new SimpleTask();
        } elseif ($task === 'scheduled') {
            return new ScheduledTask();
        }

        // 找不到對應的 Task throw exception
        throw new InvalidArgumentException("找不到 {$task} 的 Task");
    }
}