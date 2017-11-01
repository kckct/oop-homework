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
    /*** @var FileHandler */
    private $fileHandler;

    /**
     * DirectoryHandler constructor.
     */
    public function __construct()
    {
        $this->fileHandler = new FileHandler();
    }

    /**
     * 處理檔案
     * @param Candidate $candidate 描述待處理檔案的資訊
     * @param array $target byte[]
     * @return array
     */
    public function perform(Candidate $candidate, array $target): array
    {
        parent::perform($candidate, $target);

        // byte[] 為空時 直接回傳
        if (empty($target)) {
            return [];
        }

        // 將 byte[] 還原檔案並複製到其他目錄
        $this->copyToDirectory($candidate, $target);

        return $target;
    }

    /**
     * 還原檔案並複製到其他目錄
     * @param Candidate $candidate
     * @param array $target
     * @return void
     */
    private function copyToDirectory(Candidate $candidate, array $target): void
    {
        // 還原檔案
        $this->fileHandler->perform($candidate, $target);

        // 檔名
        $backupFileName = $candidate->getName() . '.backup';

        echo storage_path();

        // 將檔案移動到 config.json 內所設定的 dir 目錄
        // Storage::move($backupFileName, $candidate->getConfig()->getDir() . DIRECTORY_SEPARATOR . $backupFileName);
    }
}