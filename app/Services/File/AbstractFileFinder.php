<?php

namespace App\Services\File;

use App\Services\Candidate;
use App\Services\Config;
use ArrayIterator;

/**
 * Class AbstractFileFinder
 * @package App\Services\File
 */
abstract class AbstractFileFinder implements FileFinder
{
    /*** @var Config */
    protected $config;

    /*** @var array */
    protected $files;

    /**
     * AbstractFileFinder constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @author Paul.Tseng
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->files[$offset]);
    }

    /**
     * @author Paul.Tseng
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return isset($this->files[$offset]) ? $this->files[$offset] : null;
    }

    /**
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
     * @author Paul.Tseng
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->files[$offset]);
    }

    /**
     * @author Paul.Tseng
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->files);
    }

    /**
     * @author Paul.Tseng
     * @param string $fileName
     * @return Candidate
     */
    protected abstract function createCandidate(string $fileName): Candidate;
}