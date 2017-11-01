<?php

namespace App\Services\Handler;

use App\Services\Candidate;
use Illuminate\Support\Facades\Storage;

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
        // 還原檔案
        $this->fileHandler->perform($candidate, $target);

        // 檔名
        $backupFileName = $candidate->getName() . '.backup';

        // 將檔案移動到 config.json 內所設定的 dir 目錄
        Storage::move($backupFileName, $candidate->getConfig()->getDir() . DIRECTORY_SEPARATOR . $backupFileName);
    }
}