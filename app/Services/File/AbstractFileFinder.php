<?php

namespace App\Services\File;

use App\Services\Candidate;
use App\Services\Config;

/**
 * Class AbstractFileFinder
 * @package App\Services\File
 */
abstract class AbstractFileFinder implements FileFinder
{
    /*** @var Config */
    protected $config;

    /*** @var string[] */
    protected $files;

    /*** @var int array index */
    protected $index = 0;

    /**
     * AbstractFileFinder constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * ArrayAccess 實作
     * @author Paul.Tseng
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->files[$offset]);
    }

    /**
     * ArrayAccess 實作
     * @author Paul.Tseng
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return isset($this->files[$offset]) ? $this->createCandidate($this->files[$offset]) : null;
    }

    /**
     * ArrayAccess 實作
     * @author Paul.Tseng
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->files[] = $value;
        } else {
            $this->files[$offset] = $value;
        }
    }

    /**
     * ArrayAccess 實作
     * @author Paul.Tseng
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->files[$offset]);
    }

    /**
     * Iterator 實作
     * @return Candidate
     */
    public function current(): Candidate
    {
        return $this->createCandidate($this->files[$this->index]);
    }

    /**
     * Iterator 實作
     */
    public function next(): void
    {
        ++$this->index;
    }

    /**
     * Iterator 實作
     * @return int
     */
    public function key(): int
    {
        return $this->index;
    }

    /**
     * Iterator 實作
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->files[$this->index]);
    }

    /**
     * Iterator 實作
     */
    public function rewind(): void
    {
        $this->index = 0;
    }

    /**
     * Countable 實作
     * @return int
     */
    public function count(): int
    {
        return count($this->files);
    }

    /**
     * 產生 Candidate object
     * @author Paul.Tseng
     * @param string $fileName
     * @return Candidate
     */
    protected abstract function createCandidate(string $fileName): Candidate;
}