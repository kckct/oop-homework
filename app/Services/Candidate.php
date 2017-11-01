<?php

namespace App\Services;

use Illuminate\Support\Collection;

/**
 * Class Candidate
 * @package App\Services
 */
class Candidate
{
    /** @var Config Config 物件 */
    private $config;

    /** @var string 檔案的日期與時間 */
    private $fileDateTime;

    /** @var string 檔案名稱 */
    private $name;

    /** @var string 處理檔案的 process */
    private $processName;

    /** @var string 檔案 size */
    private $size;

    /**
     * Candidate constructor.
     * @param Collection $item
     */
    public function __construct(Collection $item)
    {
        $this->config       = $item->get('config', new Config(collect([])));
        $this->fileDateTime = $item->get('fileDateTime', '');
        $this->name         = $item->get('name', '');
        $this->processName  = $item->get('processName', '');
        $this->size         = $item->get('size', '');
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * @return string
     */
    public function getFileDateTime(): string
    {
        return $this->fileDateTime;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getProcessName(): string
    {
        return $this->processName;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }
}