<?php

namespace App\Services\File;

use App\Services\Config;
use InvalidArgumentException;

/**
 * Class FileFinderFactory
 * @package App\Services
 */
class FileFinderFactory
{
    /**
     * 建立對應的 FileFinder object
     * @param string $finder
     * @param Config $config
     * @return FileFinder
     */
    public static function create(string $finder, Config $config): FileFinder
    {
        if ($finder === 'file') {
            return new LocalFileFinder($config);
        }

        // 找不到對應的 FileFinder throw exception
        throw new InvalidArgumentException("找不到 {$finder} 的 FileFinder");
    }
}