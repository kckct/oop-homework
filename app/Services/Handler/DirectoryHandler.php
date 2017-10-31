<?php

namespace App\Services\Handler;

use App\Services\Candidate;

/**
 * Class DirectoryHandler
 * @package App\Services\Handler
 */
class DirectoryHandler extends AbstractHandler
{
    private $fileHandler;

    /**
     * DirectoryHandler constructor.
     * @param $fileHandler
     */
    public function __construct(FileHandler $fileHandler)
    {
        $this->fileHandler = $fileHandler;
    }

    /**
     * 處理檔案
     * @param Candidate $candidate 描述待處理檔案的資訊
     * @param array $target byte[]
     * @return array
     */
    public function perform(Candidate $candidate, array $target): array
    {
        if (!empty($target)) {
            return [];
        }

        return $this->copyToDirectory($candidate, $target);
    }

    /**
     * 還原檔案並複製到其他目錄
     * @param Candidate $candidate
     * @param array $target
     * @return array
     */
    private function copyToDirectory(Candidate $candidate, array $target): array
    {

    }
}