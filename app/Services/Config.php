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
     * @return string
     */
    public function getConnectionString(): string
    {
        return $this->connectionString;
    }

    /**
     * @param string $connectionString
     */
    public function setConnectionString(string $connectionString)
    {
        $this->connectionString = $connectionString;
    }

    /**
     * @return string
     */
    public function getDestination(): string
    {
        return $this->destination;
    }

    /**
     * @param string $destination
     */
    public function setDestination(string $destination)
    {
        $this->destination = $destination;
    }

    /**
     * @return string
     */
    public function getDir(): string
    {
        return $this->dir;
    }

    /**
     * @param string $dir
     */
    public function setDir(string $dir)
    {
        $this->dir = $dir;
    }

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
    public function getHandler(): string
    {
        return $this->handler;
    }

    /**
     * @param string $handler
     */
    public function setHandler(string $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation(string $location)
    {
        $this->location = $location;
    }

    /**
     * @return bool
     */
    public function isRemove(): bool
    {
        return $this->remove;
    }

    /**
     * @param bool $remove
     */
    public function setRemove(bool $remove)
    {
        $this->remove = $remove;
    }

    /**
     * @return bool
     */
    public function isSubDirectory(): bool
    {
        return $this->subDirectory;
    }

    /**
     * @param bool $subDirectory
     */
    public function setSubDirectory(bool $subDirectory)
    {
        $this->subDirectory = $subDirectory;
    }

    /**
     * @return string
     */
    public function getUnit(): string
    {
        return $this->unit;
    }

    /**
     * @param string $unit
     */
    public function setUnit(string $unit)
    {
        $this->unit = $unit;
    }
}