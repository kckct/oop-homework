<?php

namespace App\Services;

use Illuminate\Support\Collection;

/**
 * Class Schedule
 * @package App\Services
 */
class Schedule
{
    /** @var string 排程所處理的檔案格式 */
    private $ext;

    /** @var string 排程執行的間隔 */
    private $interval;

    /** @var string 排程所處理的時間 */
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