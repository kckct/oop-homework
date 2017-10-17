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
     * @return string
     */
    public function getExt(): string
    {
        return $this->ext;
    }

    /**
     * @param string $ext
     */
    public function setExt(string $ext)
    {
        $this->ext = $ext;
    }

    /**
     * @return string
     */
    public function getInterval(): string
    {
        return $this->interval;
    }

    /**
     * @param string $interval
     */
    public function setInterval(string $interval)
    {
        $this->interval = $interval;
    }

    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->time;
    }

    /**
     * @param string $time
     */
    public function setTime(string $time)
    {
        $this->time = $time;
    }
}