<?php

namespace App\Services;

/**
 * Class Config
 * @package App\Services
 */
class Config
{
    /** @var string $connectionString */
    private $connectionString;

    /** @var string $destination */
    private $destination;

    /** @var string $dir */
    private $dir;

    /** @var string $ext */
    private $ext;

    /** @var string $handler */
    private $handler;

    /** @var string $location */
    private $location;

    /** @var bool $remove */
    private $remove;

    /** @var bool $subDirectory */
    private $subDirectory;

    /** @var string $unit */
    private $unit;

    /**
     * Config constructor.
     * @param array $item
     */
    public function __construct(array $item)
    {
        $this->connectionString = $item['connectionString'];
        $this->destination      = $item['destination'];
        $this->dir              = $item['dir'];
        $this->ext              = $item['ext'];
        $this->handler          = $item['handler'];
        $this->location         = $item['location'];
        $this->remove           = $item['remove'];
        $this->subDirectory     = $item['subDirectory'];
        $this->unit             = $item['unit'];
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
     * @return string
     */
    public function getHandler(): string
    {
        return $this->handler;
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