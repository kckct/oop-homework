<?php

namespace App\Services;

use Illuminate\Support\Collection;

/**
 * Class Config
 * @package App\Services
 */
class Config
{
    /** @var string 資料庫連接字串 */
    private $connectionString;

    /** @var string 儲存目的地 */
    private $destination;

    /** @var string 處理後的目錄 */
    private $dir;

    /** @var string 檔案格式 */
    private $ext;

    /** @var array 處理方式 */
    private $handlers;

    /** @var string 備份檔案的目錄 */
    private $location;

    /** @var bool 處理完是否刪除檔案 */
    private $remove;

    /** @var bool 是否處理子目錄 */
    private $subDirectory;

    /** @var string 備份單位 */
    private $unit;

    /**
     * Config constructor.
     * @param Collection $item
     */
    public function __construct(Collection $item)
    {
        $this->connectionString = $item->get('connectionString', '');
        $this->destination      = $item->get('destination', '');
        $this->dir              = $item->get('dir', '');
        $this->ext              = $item->get('ext', '');
        $this->handlers         = $item->get('handlers', []);
        $this->location         = $item->get('location', '');
        $this->remove           = $item->get('remove', false);
        $this->subDirectory     = $item->get('subDirectory', false);
        $this->unit             = $item->get('unit', '');
    }

    /**
     * @return string
     */
    public function getConnectionString(): string
    {
        return $this->connectionString;
    }

    /**
     * @return string
     */
    public function getDestination(): string
    {
        return $this->destination;
    }

    /**
     * @return string
     */
    public function getDir(): string
    {
        return $this->dir;
    }

    /**
     * @return string
     */
    public function getExt(): string
    {
        return $this->ext;
    }

    /**
     * @return array
     */
    public function getHandlers(): array
    {
        return $this->handlers;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @return bool
     */
    public function isRemove(): bool
    {
        return $this->remove;
    }

    /**
     * @return bool
     */
    public function isSubDirectory(): bool
    {
        return $this->subDirectory;
    }

    /**
     * @return string
     */
    public function getUnit(): string
    {
        return $this->unit;
    }
}