<?php

namespace App\Services;

/**
 * Class Schedule
 * @package App\Services
 */
class Schedule
{
    /** @var string $ext */
    private $ext;

    /** @var string $interval */
    private $interval;

    /** @var string $time */
    private $time;

    /**
     * Schedule constructor.
     * @param array $item
     */
    public function __construct(array $item)
    {
        $this->ext      = $item['ext'];
        $this->interval = $item['interval'];
        $this->time     = $item['time'];
    }

    /**
     * @return string
     */
    public function getExt(): string
    {
        return $this->ext;
    }

    /**
     * @return string
     */
    public function getInterval(): string
    {
        return $this->interval;
    }

    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->time;
    }
}