<?php

namespace App\Services\File;

use App\Services\Candidate;
use App\Services\Config;

/**
 * Class LocalFileFinder
 * @package App\Services\File
 */
class LocalFileFinder extends AbstractFileFinder
{
    /**
     * LocalFileFinder constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        parent::__construct($config);

        if ($config->isSubDirectory()) {
            $this->files = $this->getSubDirectoryFiles($config);
        } else {
            
        }
    }

    private function getSubDirectoryFiles(Config $config): array
    {
        
    }
    
    /**
     * @author Paul.Tseng
     * @param string $fileName
     * @return Candidate
     */
    protected function createCandidate(string $fileName): Candidate
    {

    }
}