<?php

namespace App\Services;

use Illuminate\Support\Collection;

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
     * @param Collection $item
     */
    public function __construct(Collection $item)
    {
        $this->ext      = $item->get('ext', '');
        $this->interval = $item->get('interval', '');
        $this->time     = $item->get('time', '');
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