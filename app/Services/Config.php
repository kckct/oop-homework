<?php

namespace App\Services;

use Illuminate\Support\Collection;

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
     * @param Collection $item
     */
    public function __construct(Collection $item)
    {
        $this->connectionString = $item->get('connectionString', '');
        $this->destination      = $item->get('destination', '');
        $this->dir              = $item->get('dir', '');
        $this->ext              = $item->get('ext', '');
        $this->handler          = $item->get('handler', '');
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